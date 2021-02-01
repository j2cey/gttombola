<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UrnePrincipale
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
 *
 * @property integer|null $type_urne_id
 * @property integer|null $tombola_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class UrnePrincipale extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['typeurne','participants','participations'];
    protected $withCount = ['participants','participations'];

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

    #region Eloquent Relationships

    public function typeurne() {
        return $this->belongsTo(TypeUrne::class, 'type_urne_id');
    }

    public function tombola() {
        return $this->belongsTo(Tombola::class, 'tombola_id');
    }

    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'participant_urne_principale', 'urne_principale_id', 'participant_id')
            ->distinct();
    }

    public function participations() {
        return $this->belongsToMany(Participant::class, 'participant_urne_principale', 'urne_principale_id', 'participant_id');
    }

    #endregion

    #region Custom Functions

    #endregion
}
