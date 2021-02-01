<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ResultatTirage
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property boolean $retenu
 * @property string|null $commentaire
 *
 * @property integer|null $tirage_id
 * @property integer|null $participant_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ResultatTirage extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['participant'];

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

    public function tirage() {
        return $this->belongsTo(Tirage::class, 'tirage_id');
    }

    public function participant() {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    #endregion

    #region Custom Functions

    #endregion
}
