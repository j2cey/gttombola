<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FonctionEmploye
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $intitule
 * @property string $slug
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */

class FonctionEmploye extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region validation tools

    public static function defaultRules() {
        return [];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [
            'intitule' => ['required','string','min:3','max:100',
                //'unique:fonction_employes,intitule,NULL,id,deleted_at,NULL',
                'unique:fonction_employes,intitule,NULL,id',
            ],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'intitule' => ['required','string','min:3','max:100',
                //'unique:fonction_employes,intitule,'.$model->id.',id,deleted_at,NULL',
                'unique:fonction_employes,intitule,'.$model->id.',id',
            ],
        ]);
    }
    public static function validationMessages() {
        return [];
    }

    #endregion
}
