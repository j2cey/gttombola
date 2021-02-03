<?php

namespace App\Traits\LDAP;

use App\Models\User;
use App\Models\Status;
use App\Models\Employe;
use App\Models\PhoneNum;
use App\Models\Departement;
use App\Models\LdapAccount;
use Illuminate\Support\Str;
use App\Models\EmailAddress;
use App\Models\TypeDepartement;
use App\Models\FonctionEmploye;
use App\Models\LdapAccountImport;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Facades\Validator;

trait LdapImportTrait
{
    public function ldapGetUserByName($username) {
        return Adldap::search()->users()->find($username);
    }

    /**
     * Traite les comptes LDAP importés
     */
    public function parseImportedLdapAccounts() {
        // Tronquage de la table d'importation
        //DB::table('ldapaccountimports')->truncate();

        // Exécution de la commande d'importation
        //Artisan::call('adldap:import', ['--model' => "\App\LdapAccountImport", '--no-interaction']);

        // Traitement des lignes importées
        $accountsimported = LdapAccountImport::get();
        foreach ($accountsimported as $accountimported) {
            $this->adldapSyncUser($accountimported->name, $accountimported);
        }
    }

    public function adldapSyncUser($username, LdapAccountImport $accountimported = null) {
        $userldap = Adldap::search()->users()->find($username);
        if ($userldap) {
            //dump('1: $userldap', $userldap);
            $ldapaccount = LdapAccount::where('samaccountname', $userldap->getFirstAttribute('samaccountname'))->first();
            if (! $ldapaccount) {
                $ldapaccount = new LdapAccount();
                if (! is_null($accountimported) ) {
                    $ldapaccount->objectguid = $accountimported->objectguid;
                    $ldapaccount->email = $accountimported->email;
                    $ldapaccount->password = $accountimported->password;
                }
            }
            //dump('2: $ldapaccount', $ldapaccount);
            $newvalues = [];
            foreach ($ldapaccount->getLdapColumns() as $column) {
                $ldap_val = $userldap->getFirstAttribute($column);
                if ($ldap_val) {
                    if ($column === "thumbnailphoto") {
                        $ldap_val = decbin(ord($ldap_val));
                    }
                    $newvalues[$column] = $ldap_val;
                    $ldapaccount->{$column} = $ldap_val;
                    $newvalues[$column . "_result"] = "OK.";
                } else {
                    $newvalues[$column . "_result"] = "champs non existant pour cet utilisateur.";
                }
                $ldapaccount->{$column . "_result"} = $newvalues[$column . "_result"];
            }

            // username
            $ldapaccount->username = $ldapaccount->samaccountname ? $ldapaccount->samaccountname : "NOT_DEFINED_" . $ldapaccount->objectguid;

            $ldapaccount->save();
            //$ldapaccount->update($newvalues);
            $this->setEmployeInfos($ldapaccount, $userldap);
            $this->createUser($ldapaccount);
        }
    }

    /**
     * Synchronise un compte LDAP avec un Employe du Système
     *
     * @param \App\LdapAccount $ldapaccount
     * @param $userldap
     */
    private function setEmployeInfos(LdapAccount $ldapaccount, $userldap) {
        $employe = Employe::where('objectguid', $ldapaccount->objectguid)->first();
        if (! $employe) {
            $employe = Employe::create([
                'objectguid' => $ldapaccount->objectguid,
                'status_id' => Status::active()->first()->id,
                'nom' => "UNDEFINED"
            ]);
        }

        if ($employe) {
            foreach ($ldapaccount->getLdapColumns() as $column) {
                $ldap_val = $userldap->getFirstAttribute($column);
                if ($ldap_val) {
                    if ($column === "sn") {
                        // Nom de famille
                        $employe->nom = ucwords($ldap_val);
                    } elseif ($column === "givenname") {
                        // Prénom
                        $employe->prenom = ucwords($ldap_val);
                    } elseif ($column === "title") {
                        // fonction employe
                        $intitule_fonctionemploye = strtolower($ldap_val);
                        $intitule_fonctionemploye = ucwords($intitule_fonctionemploye);
                        $fonctionemploye = FonctionEmploye::where('slug', Str::slug($intitule_fonctionemploye))->first();
                        if (! $fonctionemploye) {
                            $fonctionemploye_values = [
                                'intitule' => $intitule_fonctionemploye,
                                'slug' => Str::slug($intitule_fonctionemploye),
                                'description' => $ldap_val,
                                'status_id' => Status::active()->first()->id,
                            ];
                            $validator = Validator::make($fonctionemploye_values, FonctionEmploye::createRules());
                            if (! $validator->fails()) {
                                $fonctionemploye = FonctionEmploye::create($fonctionemploye_values);
                                $employe->fonction_employe_id = $fonctionemploye->id;
                            } else {
                                \Log::info("FonctionEmploye " . $intitule_fonctionemploye->name . " NOT created!!!. validator->fails() : " . $validator->fails());
                                $this->logValidatorErrors($validator);
                            }
                        } else {
                            $employe->fonction_employe_id = $fonctionemploye->id;
                        }
                    } elseif ($column === "distinguishedname") {
                        // infos complets de l employé
                        $dpt_tree = str_replace("CN=" . $userldap->getFirstAttribute("cn"), "", $ldap_val);
                        $dpt_tree = str_replace(["OU=UTILISATEURS","DC=groupegt","DC=ga","OU="], "", $dpt_tree);
                        $dpt = $this->parseDepartementTree($dpt_tree);
                        if ($dpt) {
                            $employe->departement_id = $dpt->id;
                        }
                    } elseif ($column === "mail") {
                        // adresse email
                        $email = EmailAddress::where('email', $ldap_val)->first();
                        if (!$email) {
                            $employe->addNewEmailAddress($ldap_val);
                        }
                    } elseif ($column === "telephonenumber") {
                        // phone num
                        $phonenum = PhoneNum::where('numero', $ldap_val)->first();
                        if (!$phonenum) {
                            $employe->addNewPhoneNum($ldap_val);
                        }
                    } elseif ($column === "thumbnailphoto") {
                        // photo de profil
                        if ($column === "thumbnailphoto") {
                            $employe->thumbnailphoto = decbin(ord($ldap_val));
                        }
                        //$employe->thumbnailphoto = $ldap_val;
                    }
                }
            }

            $employe->save();
        }
    }

    /**
     * Parse le chemin d'un département
     * @param string $tree chemin du département (chaque branche séparée par une virgule)
     * @return \App\Models\Departement|null
     */
    private function parseDepartementTree(string $tree) {
        $tree_tab = explode(',', $tree);
        $prev_dept = null;
        $first_dept = null;
        foreach ($tree_tab as $dept) {
            if (! empty($dept)) {
                $dept = $this->formatDepartementIntitule($dept);
                $curr_dept = Departement::where('intitule', $dept)->first();
                if (!$curr_dept) {
                    // création d'un nouveau département
                    $curr_dept = Departement::create([
                        'intitule' => $dept,
                        'status_id' => Status::active()->first()->id,
                    ]);
                    // Recherche du type de dépertement en fonction de l'intitulé
                    $type_dpt_id = $this->parseDepartementType($dept);
                    if ($type_dpt_id) {
                        $curr_dept->type_departement_id = $type_dpt_id;
                    }
                }
                // Set du parent du précédent
                if ($prev_dept) {
                    $prev_dept->departement_parent_id = $curr_dept->id;
                    $prev_dept->save();
                } else {
                    $first_dept = $curr_dept;
                }
                $curr_dept->description = $dept;
                $curr_dept->save();
                // On assigne le précédent
                $prev_dept = $curr_dept;
            }
        }
        return $first_dept;
    }

    /**
     * Essaie de déduire le type d'un département
     * @param $intitule string intitulé du département
     * @return |null
     */
    private function parseDepartementType(string $intitule) {
        if (strpos(strtolower($intitule), 'direction') !== false) {
            $type = TypeDepartement::where('intitule', 'Direction')->first();
            return $type->id;
        } elseif (strpos(strtolower($intitule), 'division') !== false) {
            $type = TypeDepartement::where('intitule', 'Division')->first();
            return $type->id;
        } elseif (strpos(strtolower($intitule), 'zone') !== false) {
            $type = TypeDepartement::where('intitule', 'Zone')->first();
            return $type->id;
        } elseif (strpos(strtolower($intitule), 'service') !== false) {
            $type = TypeDepartement::where('intitule', 'Service')->first();
            return $type->id;
        } elseif (strpos(strtolower($intitule), 'agence') !== false) {
            $type = TypeDepartement::where('intitule', 'Agence')->first();
            return $type->id;
        } else {
            return null;
        }
    }

    /**
     * Formate l'intitulé d'un département
     * @param string $intitule
     * @return string
     */
    private function formatDepartementIntitule(string $intitule) {
        $sigles = config('Settings.ldap.liste_sigles');
        $intitule_tab = explode(' ', $intitule);

        for ($i = 0; $i < count($intitule_tab); $i++) {
            // Mettre en minuscules
            $intitule_tab[$i] = strtolower($intitule_tab[$i]);

            // Replaces: tous les sigles
            foreach ($sigles as $sigle) {
                if (strlen($intitule_tab[$i]) == strlen($sigle)) {
                    $intitule_tab[$i] = str_replace(strtolower($sigle), strtoupper($sigle), $intitule_tab[$i]);
                }
            }

            // Mettre les debuts de mot en Majuscule
            $firs_car = substr($intitule_tab[$i], 0, 1);
            if (ctype_alpha($firs_car)) {
                // Le 1er caractère est alphabétique
                $intitule_tab[$i] = ucwords($intitule_tab[$i]);
            } else {
                // Le 1er caractère n'est alphabétique
                // Alors on met 1er caractère du reste en Majuscule
                $intitule_tab[$i] = $firs_car . ucwords(substr($intitule_tab[$i], 1, strlen($intitule_tab[$i]) - 1));
            }

            // Les sigles entre parenthèses
            if ( (substr($intitule_tab[$i], 0, 1) === "(") && (substr($intitule_tab[$i], -1) === ")") && (strlen($intitule_tab[$i]) <= 7) ) {
                $intitule_tab[$i] = strtoupper($intitule_tab[$i]);
            }
        }
        $intitule = implode(' ', $intitule_tab);
        return $intitule;
    }

    /**
     * Créer un compte d'accès à l'application
     * @param LdapAccount $ldapaccount
     */
    private function createUser(LdapAccount $ldapaccount) {
        if (! User::where('ldap_account_id', $ldapaccount->id)->first()) {
            if (! User::where('email', $ldapaccount->mail)->first()) {
                if ($ldapaccount->mail) {
                    $usermail = $ldapaccount->mail;
                } else {
                    $usermail = $ldapaccount->userprincipalname;
                }
                $role_id = config('Settings.roles.default');
                $user_values = [
                    'name' => $ldapaccount->name,
                    'username' => $ldapaccount->samaccountname,
                    'objectguid' => $ldapaccount->objectguid,
                    'email' => $usermail,
                    'is_ldap' => true,
                    'ldap_account_id' => $ldapaccount->id,
                    'status_id' => Status::inactive()->first()->id,
                    'roles' => json_encode([$role_id]),
                    'password' => 'gestocksecret',
                    'confirm_password' => 'gestocksecret'
                ];

                $validator = Validator::make($user_values, User::createRules());
                if (! $validator->fails()) {
                    \Log::info("user " . $ldapaccount->name . " created. validator->fails() : " . $validator->fails());
                    unset($user_values['roles']);
                    unset($user_values['confirm_password']);
                    $user_values['password'] = bcrypt($user_values['password']);
                    $user = User::create($user_values);
                    $user->assignRole([$role_id]);
                } else {
                    \Log::info("user " . $ldapaccount->name . " NOT created!!!. validator->fails() : " . $validator->fails());
                    $this->logValidatorErrors($validator);
                }
            }
        }
    }

    /**
     * Enregistre le message d'erreur de validation dans les logs
     * @param $validator
     */
    private function logValidatorErrors($validator) {
        $errors = $validator->errors();
        foreach ($errors->all() as $key => $message) {
            \Log::info($message);
        }
    }
}
