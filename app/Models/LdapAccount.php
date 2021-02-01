<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Traits\Base\BaseTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class LdapAccount
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $objectguid
 * @property string $username
 * @property string|null $email
 * @property string|null $password
 * @property string|null $cn
 * @property string|null $cn_result
 * @property string|null $sn
 * @property string|null $sn_result
 * @property string|null $title
 * @property string|null $title_result
 * @property string|null $description
 * @property string|null $description_result
 * @property string|null $physicaldeliveryofficename
 * @property string|null $physicaldeliveryofficename_result
 * @property string|null $telephonenumber
 * @property string|null $telephonenumber_result
 * @property string|null $givenname
 * @property string|null $givenname_result
 * @property string|null $distinguishedname
 * @property string|null $distinguishedname_result
 * @property string|null $service
 * @property string|null $division
 * @property string|null $direction
 * @property string|null $agence
 * @property string|null $zone
 * @property string|null $whencreated
 * @property string|null $whencreated_result
 * @property string|null $whenchanged
 * @property string|null $whenchanged_result
 * @property string|null $department
 * @property string|null $department_result
 * @property string|null $company
 * @property string|null $company_result
 * @property string|null $name
 * @property string|null $name_result
 * @property string|null $badpwdcount
 * @property string|null $badpwdcount_result
 * @property string|null $logoncount
 * @property string|null $logoncount_result
 * @property string|null $samaccountname
 * @property string|null $samaccountname_result
 * @property string|null $mail
 * @property string|null $mail_result
 * @property string|null $userprincipalname
 * @property string|null $userprincipalname_result
 * @property string|null $thumbnailphoto
 * @property string|null $thumbnailphoto_result
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class LdapAccount extends Authenticatable implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, BaseTrait;

    protected $guarded = [];

    #region Custom Functions

    public function getTableColumns() {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        //$columns = \DB::getSchemaBuilder()->getColumnListing($this->getTable());

        return \Schema::getColumnListing($this->getTable());;
    }

    public function getLdapColumns() {
        $ldap_cols = [];
        //$no_ldap_cols = ['id','objectguid','created_at','updated_at'];
        foreach ($this->getTableColumns() as $col) {
            //if ( substr($col,-7) !== "_result" && ( ! in_array($col, $no_ldap_cols) ) ) {
            if ( substr($col,-7) === "_result" ) {
                $ldap_cols[] = str_replace("_result", "", $col);
            }
        }
        return $ldap_cols;
    }

    public function getAuthIdentifier()
    {
        return $this->samaccountname;
    }

    #endregion
}
