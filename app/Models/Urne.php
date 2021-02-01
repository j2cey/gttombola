<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Urne
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
 * @property string $table_participation
 * @property string $prefix_selection_numero
 * @property string|null $description
 *
 * @property integer|null $type_urne_id
 * @property integer|null $tombola_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Urne extends BaseModel implements Auditable
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

    #region Eloquent Relationships

    public function typeurne() {
        return $this->belongsTo(TypeUrne::class, 'type_urne_id');
    }

    public function tombola() {
        return $this->belongsTo(Tombola::class, 'tombola_id');
    }

    public function participants()
    {
        //return $this->belongsToMany(Participant::class, 'participant_urne_00', 'urne_id', 'participant_id');
        if ($this->table_participation === "participant_urne_00") {
            return $this->belongsToMany(Participant::class, 'participant_urne_00', 'urne_id', 'participant_id');
        } elseif ($this->table_participation === "participant_urne_01") {
            return $this->belongsToMany(Participant::class, 'participant_urne_01', 'urne_id', 'participant_id');
        } elseif ($this->table_participation === "participant_urne_02") {
            return $this->belongsToMany(Participant::class, 'participant_urne_02', 'urne_id', 'participant_id');
        } elseif ($this->table_participation === "participant_urne_03") {
            return $this->belongsToMany(Participant::class, 'participant_urne_03', 'urne_id', 'participant_id');
        } elseif ($this->table_participation === "participant_urne_04") {
            return $this->belongsToMany(Participant::class, 'participant_urne_04', 'urne_id', 'participant_id');
        } else {
            return $this->belongsToMany(Participant::class, 'participant_urne_05', 'urne_id', 'participant_id');
        }
        //return null;
    }

    public function participantions() {
        if ($this->table_participation === "participant_urne_00") {
            return $this->belongsToMany(Participant::class, 'participant_urne_00', 'urne_id', 'participant_id')
                ->distinct();
        } elseif ($this->table_participation === "participant_urne_01") {
            return $this->belongsToMany(Participant::class, 'participant_urne_01', 'urne_id', 'participant_id')
                ->distinct();
        } elseif ($this->table_participation === "participant_urne_02") {
            return $this->belongsToMany(Participant::class, 'participant_urne_02', 'urne_id', 'participant_id')
                ->distinct();
        } elseif ($this->table_participation === "participant_urne_03") {
            return $this->belongsToMany(Participant::class, 'participant_urne_03', 'urne_id', 'participant_id')
                ->distinct();
        } elseif ($this->table_participation === "participant_urne_04") {
            return $this->belongsToMany(Participant::class, 'participant_urne_04', 'urne_id', 'participant_id')
                ->distinct();
        } else {
            return $this->belongsToMany(Participant::class, 'participant_urne_05', 'urne_id', 'participant_id')
                ->distinct();
        }
        //return null;
    }

    #endregion

    #region Custom Functions

    #endregion
}
