<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Participation
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer $valeur
 *
 * @property integer|null $base_participation_id
 * @property integer|null $participant_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Participation extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [

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

        ];
    }

    #endregion

    #region Eloquent Relationships

    public function baseparticipation() {
        return $this->belongsTo(BaseParticipation::class, 'base_participation_id');
    }

    public function participant() {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    #endregion

    #region Custom Functions

    public static function getFileUploadMaxSize($type_wanted) {
        $val_mo = config('Settings.files.uploads.max_size.any');
        return (new Tombola())->convert_bytes($val_mo, "Mo", $type_wanted);
    }

    #endregion
}
