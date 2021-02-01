<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\LDAP\LdapImportTrait;

class LdapAccountsParse extends Command
{
    use LdapImportTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ldapaccount:parseimported';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse les comptes LDAP importés';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("ldapaccount:parseimported en cours de traitement...");
        $this->parseImportedLdapAccounts();
        \Log::info("ldapaccount:parseimported Traitement termine.");
        return 0;
    }
}
