<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Traits\PhoneNum\HasPhoneNums;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\EmailAddress\HasEmailAddresses;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Employe
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $nom
 * @property string|null $matricule
 * @property string|null $prenom
 * @property string|null $nom_complet
 * @property string|null $adresse
 * @property string|null $objectguid
 * @property string|null $thumbnailphoto
 *
 * @property integer|null $fonction_employe_id
 * @property integer|null $departement_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Employe extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, HasEmailAddresses, HasPhoneNums;
    protected $guarded = [];

    /**
     * Get the employe's full concatenated name.
     * -- Must postfix the word 'Attribute' to the function name
     *
     * @return string
     */
    public function getNomCompletAttribute()
    {
        return "{$this->nom} {$this->prenom}";
    }

    #region Validation Tools

    public static function defaultRules() {
        return [
            'nom' => ['required','string','min:3','max:255',],
            'fonction_employe_id' => ['required','integer',],
        ];
    }
    public static function createRules()  {
        return array_merge(self::defaultRules(), [
            'nouveau_email' => ['required'],
            'nouveau_phone' => ['required'],
            'matricule' => ['required','unique:employes,matricule,NULL,id,deleted_at,NULL',],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'matricule' => ['required','unique:employes,matricule,'.$model->id.',id,deleted_at,NULL',],
        ]);
    }
    public static function validationMessages() {
        return [];
    }

    #endregion

    #region Eloquent Relationships

    /**
     * Renvoie la Fonction de l employe.
     */
    public function fonction() {
        return $this->belongsTo(FonctionEmploye::class, 'fonction_employe_id');
    }

    /**
     * Renvoie l Assignation de l employe.
     */
    public function departement() {
        return $this->belongsTo(Departement::class);
    }


    /**
     * Retourne toutes les Departements pour lesquelles cet employe est responsable.
     */
    public function departementsResponsable() {
        return $this->hasMany(Departement::class, 'employe_responsable_id');
    }

    #endregion
}
