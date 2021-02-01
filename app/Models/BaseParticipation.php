<?php

namespace App\Models;

use App\Traits\File\HasFile;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\File\HasImportFileResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BaseParticipation
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $fichier
 * @property string $fichier_type
 * @property integer $fichier_size
 * @property string $separateur_colonnes
 *
 * @property integer|null $tombola_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BaseParticipation extends BaseModel implements Auditable
{
    use HasFactory, HasFile, HasImportFileResult, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['importfileresults'];
    protected $appends = ['importfileresult'];

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

    public function tombola() {
        return $this->belongsTo(Tombola::class, 'tombola_id');
    }

    public function subfiles() {
        return $this->hasMany(BaseParticipationSubfile::class, 'base_participation_id');
    }

    #endregion

    #region Custom Functions

    #endregion
    public function getNbToImport(): int
    {
        return $this->subfiles()->sum('nb_rows');
    }

    public function getNbImportProcessing(): int
    {
        return $this->subfiles()->sum('nb_rows_processing');
    }

    public function getNbImportSuccess(): int
    {
        return $this->subfiles()->sum('nb_rows_success');
    }

    public function getNbImportFailed(): int
    {
        return $this->subfiles()->sum('nb_rows_failed');
    }

    public function getNbImportProcessed(): int
    {
        return $this->subfiles()->sum('nb_rows_processed');
    }
}
