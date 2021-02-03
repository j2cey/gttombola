<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // groupe app_name
        $this->createNew("app_name", null, "Moov-Africa Tombolas", "string", ",", "Application Name.");
        // groupe roles
        $group = $this->createNew("roles", null, null, "string", ",", "settings Roles.");
        $this->createNew("default", $group->id, "1", "integer", ",", "Role par défaut à la creéation d un utilisateur dont le role n est pas explicitement déterminé.");
        // groupe files
        $group = $this->createNew("files", null, null, null, ",", "settings Files.");
        // sub groupe files.uploads
        $group = $this->createNew("uploads", $group->id, null, null, ",", "Uploads.");
        // sub groupe files.uploads.max_size
        $group = $this->createNew("max_size", $group->id, null, null, ",", "Max Size.");
        $this->createNew("any", $group->id, "70", "integer", ",", "Max any file size.");
        $this->createNew("video", $group->id, "70", "integer", ",", "Max video file size.");

        // LDAP
        $group = $this->createNew("ldap", null, null, null, ",", "settings LDAP.");
        $this->createNew("liste_sigles", $group->id, "gt,rh,si,it,sav,in,bss,msan,rva,erp,dr", "array", ",", "liste des sigles (à prendre en compte dans l importation LDAP).");

        // groupe tombola
        $group_tombola = $this->createNew("tombola", null, null, null, ",", "settings Tombola.");
        // sub groupe base_participations
        $group = $this->createNew("base_participations", $group_tombola->id, null, null, ",", "settings Tombola, Base de Participations.");
        $group_O = $this->createNew("files", $group->id, null, null, ",", "settings fichiers.");
        $group = $this->createNew("split", $group_O->id, null, null, ",", "settings fichiers split.");
        $this->createNew("nombre_max_lignes", $group->id, "100", "integer", ",", "settings nombre max de lignes.");
        $group = $this->createNew("import", $group_O->id, null, null, ",", "settings Importaion fichier.");
        $group = $this->createNew("cron", $group->id, null, null, ",", "settings CRON.");
        $this->createNew("nombre_traitements_par_minute", $group->id, "5", "integer", ",", "Nombre de traitements par minute pour le CRON.");
        // sub groupe tombola.urnes
        $group = $this->createNew("urnes", $group_tombola->id, null, null, ",", "Settings Tombola Urnes.");
        // sub groupe tombola.urnes.automatics
        $group_0 = $this->createNew("automatics", $group->id, null, null, ",", "Settings Tombola Urnes - Automatics.");
        // sub groupe tombola.urnes.automatics.principale
        $group = $this->createNew("principale", $group_0->id, null, null, ",", "Principale automatics urnes.");
        $this->createNew("01", $group->id, "Principale|all_select|XXX|Urne principale contenant tous les participants", "array", "|", "automatic urne 01.");
        // sub groupe tombola.urnes.automatics.secondaire
        $group = $this->createNew("secondaire", $group_0->id, null, null, ",", "Secondaire automatics urnes.");
        $this->createNew("01", $group->id, "AB 060|num_select|060|Urne contenant tous participants dont le numéro commence par 060", "array", "|", "automatic urne 02.");
        $this->createNew("02", $group->id, "AB 062|num_select|062|Urne contenant tous participants dont le numéro commence par 062", "array", "|", "automatic urne 03.");
        $this->createNew("03", $group->id, "AB 065|num_select|065|Urne contenant tous participants dont le numéro commence par 065", "array", "|", "automatic urne 04.");
        $this->createNew("04", $group->id, "AB 066|num_select|066|Urne contenant tous participants dont le numéro commence par 066", "array", "|", "automatic urne 05.");
    }

    private function createNew($name, $group_id = null, $value = null, $type = null, $array_sep = ",", $description = null) {
        $data = ['name'  => $name, 'array_sep' => $array_sep];
        if (! is_null($group_id)) { $data['group_id'] = $group_id; }
        if (! is_null($value)) { $data['value'] = $value; }
        if (! is_null($type)) { $data['type'] = $type; }
        if (! is_null($description)) { $data['description'] = $description; }
        return Setting::create($data);
    }
}
