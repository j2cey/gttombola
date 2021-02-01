<?php

namespace App\Http\Controllers;

//use App\Traits\LDAP\LdapConnectTrait;
use App\Traits\LDAP\LdapImportTrait;
use Illuminate\Http\Request;

class CustomLdapController extends Controller
{
    //use LdapConnectTrait, LdapImportTrait;

    public function test()
    {
        //$ldapuser = $this->ldapGetUserByName("Flore OWONDEAULT BERRE");
        //dd($ldapuser);
    }

    public function sync() {
        //$this->importLdapAccounts();
    }
}
