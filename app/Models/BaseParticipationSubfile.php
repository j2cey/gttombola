<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Support\Carbon;
use App\Traits\Urne\CanImportToUrne;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\File\HasImportFileResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BaseParticipationSubfile
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property boolean $imported
 *
 * @property Carbon $importstart_at
 * @property Carbon $importend_at
 *
 * @property integer $nb_rows
 * @property boolean $import_processing
 * @property integer $nb_rows_success
 * @property integer $nb_rows_failed
 * @property integer $nb_rows_processing
 * @property integer $nb_rows_processed
 *
 * @property string $row_last_processed
 * @property integer $nb_try
 * @property Json $report
 *
 * @property Carbon $suspended_at
 * @property integer|null $base_participation_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BaseParticipationSubfile extends BaseModel implements Auditable
{
    use HasFactory, HasImportFileResult, CanImportToUrne, \OwenIt\Auditing\Auditable;

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

    #endregion

    #region Custom Functions

    #endregion
    public function getNbToImport(): int
    {
        return $this->nb_rows;
    }

    public function getNbImportProcessing(): int
    {
        return $this->nb_rows_processing;
    }

    public function getNbImportSuccess(): int
    {
        return $this->nb_rows_success;
    }

    public function getNbImportFailed(): int
    {
        return $this->nb_rows_failed;
    }

    public function getNbImportProcessed(): int
    {
        return $this->nb_rows_processed;
    }
}
