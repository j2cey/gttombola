<?php

namespace App\Models;

use App\Traits\Base\Uuidable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ImportFileResult
 * @package App\Models
 *
 * @property integer $id
 * @property string $uuid
 *
 * @property Carbon $importstart_at
 * @property Carbon $importend_at
 * @property integer $nb_to_import
 * @property integer $nb_import_processing
 * @property integer $nb_import_success
 * @property integer $nb_import_failed
 * @property integer $nb_import_processed
 * @property integer $import_rate
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ImportFileResult extends Model
{
    use HasFactory, Uuidable;

    protected $guarded = [];
    public function getRouteKeyName() { return 'uuid'; }

    public static function boot(){
        parent::boot();

        // Avant creation
        self::creating(function($model){

        });

        // Après création
        self::created(function($model){
            // On met à jour le statut de la campagne parente
            //$model->setParentStatus();
        });

        // Après chaque modification
        self::updated(function($model){
            // On met à jour le statut de la campagne parente
            //$model->setParentStatus();
        });
    }
}
