<?php

namespace App\Models;

use App\Traits\Base\BaseTrait;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
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
 * @property string $email
 * @property string $username
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $image
 * @property boolean $is_local
 * @property boolean $is_ldap
 * @property string|null $objectguid
 *
 * @property string $login_type
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, HasRoles, \OwenIt\Auditing\Auditable, BaseTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'name',
        'email',
        'password',

        'username',
        'image',
        'is_local',
        'is_ldap',
        'objectguid',
        'ldap_account_id'
    ];*/
    protected $guarded = [];

    public function getRouteKeyName() { return 'uuid'; }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    #region Validation Tools

    public static function defaultRules() {
        return [
            'name' => ['required','string',],
        ];
    }
    public static function createRules()  {
        return array_merge(self::defaultRules(), [
            'email' => ['required',
                'unique:users,email,NULL,id',
            ],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'email' => ['required',
                'unique:users,email,'.$model->id.',id',
            ]
        ]);
    }
    public static function validationMessages() {
        return [];
    }

    #region Eloquent Relationships

    public function status() {
        return $this->belongsTo(Status::class);
    }

    /**
     * Renvoie le Compte LDAP du User.
     */
    public function ldapaccount() {
        return $this->belongsTo(LdapAccount::class, 'ldap_account_id');
    }

    #endregion

    #region Custom Functions

    public function isActive() {
        //return $this->is_local || $this->is_ldap;
        return Status::active()->first() ? $this->status_id === Status::active()->first()->id : false;
    }

    #endregion
}
