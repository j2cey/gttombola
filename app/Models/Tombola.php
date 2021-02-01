<?php

namespace App\Models;

use App\Traits\Data\HasData;
use App\Traits\File\HasFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\File\HasImportFileResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Tombola
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $titre
 * @property string|null $description
 * @property string|null $fichier_reglement
 * @property string|null $fichier_reglement_type
 * @property integer|null $fichier_reglement_size
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Tombola extends BaseModel implements Auditable
{
    use HasFactory, HasData, HasFile, HasImportFileResult, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $appends = ['lastbaseparticipation','importfileresult'];
    protected $with = ['parametreparticipation','baseparticipations','importfileresults'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'titre' => ['required'],
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [
            'fichier_reglement' => ['required','file','max:'. Tombola::getFileUploadMaxSize("ko")],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function messagesRules() {
        return [
            'titre.required' => 'Prière de Renseigner le Titre',
            'fichier_reglement.required' => 'Prière de télécharger le fichier de règlement',
            'fichier_reglement.file' => 'Le fichier de règlement doit etre un fichier valide',
            'fichier_reglement.max' => 'La taille du fichier de règlement doit etre de ' . Tombola::getFileUploadMaxSize("Mo") .' Mo max',
        ];
    }

    #endregion

    public function getLastbaseparticipationAttribute() {
        return $this->baseparticipations()->orderBy('created_at', 'DESC')->first();
    }

    #region Eloquent Relationships

    public function parametreparticipation() {
        return $this->hasOne(ParametreParticipation::class, 'tombola_id');
    }

    public function urneprincipales() {
        return $this->hasMany(UrnePrincipale::class, 'tombola_id');
    }

    public function urnesecondaires() {
        return $this->hasMany(UrneSecondaire::class, 'tombola_id');
    }

    public function baseparticipations() {
        return $this->hasMany(BaseParticipation::class, 'tombola_id')
            ->orderBy('created_at', 'DESC');
    }

    #endregion

    #region Custom Functions

    public static function getFileUploadMaxSize($type_wanted) {
        $val_mo = config('Settings.files.uploads.max_size.any');
        return (new Tombola())->convert_bytes($val_mo, "Mo", $type_wanted);
    }

    public function createAutomaticsUrnes() {
        //$participation_tables = ["participant_urne_00","participant_urne_01","participant_urne_02","participant_urne_03","participant_urne_04","participant_urne_05"];
        //$participation_tables_id = 0;
        // Principale
        foreach (config('Settings.tombola.urnes.automatics.principale') as $urne) {
            $typeurne = TypeUrne::where('code', $urne[1])->first();
            UrnePrincipale::create([
                'titre' => $urne[0],
                'description' => $urne[3],
                'tombola_id' => $this->id,
                'type_urne_id' => $typeurne->id,
            ]);

            //$participation_tables_id ++;
            //$participation_tables_id = ($participation_tables_id == count($participation_tables)) ? 0 :  $participation_tables_id;
        }

        // Secondaire
        foreach (config('Settings.tombola.urnes.automatics.secondaire') as $urne) {
            $typeurne = TypeUrne::where('code', $urne[1])->first();
            UrneSecondaire::create([
                'titre' => $urne[0],
                'prefix_selection_numero' => $urne[2],
                'description' => $urne[3],
                'tombola_id' => $this->id,
                'type_urne_id' => $typeurne->id,
            ]);

            //$participation_tables_id ++;
            //$participation_tables_id = ($participation_tables_id == count($participation_tables)) ? 0 :  $participation_tables_id;
        }
    }

    #endregion
    public function getNbToImport(): int
    {
        $nb_to_import = 0;
        $nb_processing = 0;
        foreach ($this->baseparticipations as $baseparticipation) {
            if (!$baseparticipation->importfileresult->importend_at) {
                $nb_to_import += $baseparticipation->getNbToImport();
                $nb_processing++;
            }
        }
        return $nb_to_import;
    }

    public function getNbImportProcessing(): int
    {
        $nb_import_processing = 0;
        foreach ($this->baseparticipations as $baseparticipation) {
            if (!$baseparticipation->importfileresult->importend_at) {
                $nb_import_processing += $baseparticipation->getNbImportProcessing();
            }
        }
        return $nb_import_processing;
    }

    public function getNbImportSuccess(): int
    {
        $nb_import_success = 0;
        foreach ($this->baseparticipations as $baseparticipation) {
            if (!$baseparticipation->importfileresult->importend_at) {
                $nb_import_success += $baseparticipation->getNbImportSuccess();
            }
        }
        return $nb_import_success;
    }

    public function getNbImportFailed(): int
    {
        $nb_import_failed = 0;
        foreach ($this->baseparticipations as $baseparticipation) {
            if (!$baseparticipation->importfileresult->importend_at) {
                $nb_import_failed += $baseparticipation->getNbImportFailed();
            }
        }
        return $nb_import_failed;
    }

    public function getNbImportProcessed(): int
    {
        $nb_import_processed = 0;
        foreach ($this->baseparticipations as $baseparticipation) {
            if (!$baseparticipation->importfileresult->importend_at) {
                $nb_import_processed += $baseparticipation->getNbImportProcessed();
            }
        }
        return $nb_import_processed;
    }
}
