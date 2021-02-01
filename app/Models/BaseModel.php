<?php

namespace App\Models;

use App\Traits\Base\BaseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class BaseModel
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BaseModel extends Model
{
	//comment to test git push
    use BaseTrait;

    public function getRouteKeyName() { return 'uuid'; }

    #region Eloquent Relationships

    public function status() {
        return $this->belongsTo(Status::class);
    }

    #endregion

    #region Scopes

    public function scopeDefault($query, $exclude = []) {
        return $query
            ->where('is_default', true)->whereNotIn('id', $exclude);
    }

    #endregion
}
