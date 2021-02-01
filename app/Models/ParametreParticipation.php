<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ParametreParticipation
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $separateur_colonnes
 * @property integer $position_numero
 * @property integer $position_valeur
 * @property bool $participation_unique
 * @property string $participation_unite
 * @property integer $participation_valeurunitaire
 *
 * @property integer|null $tombola_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ParametreParticipation extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'titre' => ['required'],
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function messagesRules() {
        return [
            'titre.required' => 'Prière de Renseigner le Titre',
        ];
    }

    #endregion

    #region Custom Functions

    #endregion
}
