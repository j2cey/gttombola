<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BaseParticipationSubfile;

class BaseParticipationImportfiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'baseparticipation:importfiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe les fichiers de base de participation non importés';

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
        $nb_files_treated = 0;
        for ($i = 0; $i < config('Settings.tombola.base_participations.files.import.cron.nombre_traitements_par_minute'); $i++) {
            $file_to_import = BaseParticipationSubfile::where('imported', 0)->where('import_processing', 0)->whereNull('suspended_at')->with('baseparticipation')->first();

            \Log::info("baseparticipation:importfiles en cours de traitement...");

            if ($file_to_import) {
                $file_to_import->importToUrne();
                //event(new SmsresultEvent($file_to_import->planning->campaign->smsresult));
                //$this->info('baseparticipation:importfiles execute avec succes! 1 fichier traité.');
                $nb_files_treated++;
            } else {
                //$this->info('Aucun fichier a traiter.');
            }
        }

        if ($nb_files_treated > 0) {
            $this->info('baseparticipation:importfiles execute avec succes! ' . $nb_files_treated . ' fichier(s) traité(s).');
        } else {
            $this->info('Aucun fichier a traiter.');
        }

        \Log::info("sbaseparticipation:importfiles Traitement termine.");
        return 0;
    }
}
