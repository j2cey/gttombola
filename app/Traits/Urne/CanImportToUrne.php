<?php


namespace App\Traits\Urne;


use App\Models\Participant;
use App\Traits\Report\ReportableTrait;

trait CanImportToUrne
{
    use ReportableTrait;

    public function importToUrne() {
        // mark as processing
        $this->update(['import_processing' => 1]);

        $subfiles_dir = config('app.tombolas_participations_subfiles_dir');
        $raw_dir = config('app.RAW_FOLDER');
        $file_fullpath = $subfiles_dir.'/'.$this->name;
        $baseparticipation = $this->baseparticipation;
        $tombola = $baseparticipation->tombola;

        $csvData = file_get_contents($raw_dir.'/'.$file_fullpath);
        $rows = array_map("str_getcsv", explode("\n", $csvData));

        for ($i = 0; $i < $this->nb_rows; $i++) {
            $row_current = $i + 1;
            $row = $rows[$i];

            $can_process_line = ($row_current > $this->row_last_processed);
            if ($can_process_line) {
                $report_line = "";
                if ( $this->getReportLine($row_current, $report_line,true) ) {
                    // Cette ligne peut être traité si son dernier traitement a été un échec
                    if ($report_line[1] < 0) {
                        $can_process_line = true;
                        $this->nb_rows_failed -= 1;
                        $this->nb_rows_processed -= 1;
                        //$planning->addImportResult(0, 0, 0, -1, -1);
                    } else {
                        // line déjà traité avec succès, alors ...
                        // on la remet dans le rapport
                        $this->addToReport($row_current,$report_line[2],$report_line[1]);
                        // on assigne la dernière ligne traitée
                        $this->row_last_processed = $row_current;
                        $can_process_line = false;
                    }
                }
            }

            if ($can_process_line) {

                $this->nb_rows_processing += 1;
                //$planning->addImportResult(0, 1, 0, 0, 0);
                $this->save();
                //$planning->setImportResult();

                $participant = new Participant();
                $valeur = 1;

                // récuration des paramètres de la ligne
                $row_parse_ok = $this->getParameters($row_current, $row[0], $tombola, $participant, $valeur);

                if ($row_parse_ok) {
                    // Insertion dans Participation

                    // Insertion dans les Urnes
                    $this->manageUrnesInsert($tombola,$participant,$valeur);

                    $this->nb_rows_success += 1;
                    //$planning->addSendResult(1, 0, 0, 0, 0);
                } else {
                    $this->nb_rows_failed += 1;
                }

                $this->nb_rows_processing -= 1;
                $this->nb_rows_processed += 1;

                // Save smsresult
                //$planning->addImportResult(0, -1, ($row_parse_ok ? 1 : 0), ($row_parse_ok ? 0 : 1), 1);

                $this->save();
                $baseparticipation->setImportResult();

                // MAJ du SmscampaingFile
                $this->row_last_processed = $row_current;

                //$campaign_forevent = Smscampaign::where('id', $planning->smscampaign_id)->first();
                //event(new SmsresultEvent($campaign_forevent,$planning->campaign->smsresult));
            }
        }
        $this->nb_try += 1;
        // unmark as processing
        $this->import_processing = 0;
        $this->save();
        // mark file processed if any
        $this->imported = $this->nb_rows == $this->nb_rows_processed ? 1 : 0;
        $this->save();
        $baseparticipation->setImportResult();
        $tombola->setImportResult();
    }

    private function manageUrnesInsert($tombola, $participant, $valeur) {
        if ($tombola->parametreparticipation->participation_unique) {
            // on insert que si le numéro n'existe pas déjà
            $participant_occur = $tombola->urneprincipales[0]->participations()
                ->where('participant_id', $participant->id)->count();
            if ($participant_occur === 0) {
                $this->insertIntoUrnes($tombola, $participant);
            }
        } else {
            // on insert plusieurs fois
            $times = $valeur / $tombola->parametreparticipation->participation_valeurunitaire;
            $this->insertIntoUrnes($tombola, $participant,$times);
        }
    }

    private function insertIntoUrnes($tombola, $participant, $times = 1) {
        for ($i = 0; $i < $times; $i++) {
            // Insert urne principale
            $posi = $tombola->urneprincipales[0]->participations()->count('participant_id');
            $tombola->urneprincipales[0]->participations()->attach($participant->id, ['posi' => $posi]);
            // Insert urnes secondaires
            for ($j = 0; $j < count($tombola->urnesecondaires); $j++) {
                if ( substr($participant->numero,0,3) === substr($tombola->urnesecondaires[$j]->prefix_selection_numero,0,3) ) {
                    $posi = $tombola->urnesecondaires[$j]->participations()->count('participant_id');
                    $tombola->urnesecondaires[$j]->participations()->attach($participant->id, ['posi' => $posi]);
                }
            }
        }
    }

    private function parseValeur($valeur_in, &$valeur_out, &$report_msg) {
        $parse_result = false;
        if (empty($valeur_in)) {
            $valeur_out = 1;
            $report_msg = "valeur vide remplacee par 1";
        } else {
            $valeur_out = $valeur_in;
            $parse_result = true;
            $report_msg = "valeur recuperee avec succes";
        }
        return $parse_result;
    }

    private function parseMobile($mobile, &$participant, &$report_msg) {
        $mobile_local = substr($mobile, -8);
        $mobile_local_str = "0" . $mobile_local;
        $parse_result = false;
        if (is_numeric($mobile_local)) {
            $participant = Participant::updateOrCreate([
                'numero' => $mobile_local_str,
                'ab_numero' => substr($mobile_local_str,0,3)
            ]);
            $parse_result = true;
            $report_msg = "numeros recupere avec succes";
        } else {
            $receiver = null;
            $report_msg = "le numero " . $mobile . " n'est pas valide";
        }
        return $parse_result;
    }

    private function getParameters($row_current, $row, $tombola, &$participant, &$valeur) {
        $participant = new Participant();
        $parameters_ok = false;
        $parameters_result = -1;

        $report_msg = "";

        if (strpos($row, $tombola->parametreparticipation->separateur_colonnes) === false) {
            $report_msg = "Separateur de colonnes non trouve!";
        } else {
            $position_numero = ($tombola->parametreparticipation->position_numero - 1);
            $position_valeur = $tombola->parametreparticipation->position_valeur === -1 ? -1 :($tombola->parametreparticipation->position_valeur - 1);
            $row_tab = explode($tombola->parametreparticipation->separateur_colonnes, $row);
            $parameters_ok = $this->parseMobile($row_tab[$position_numero], $participant, $report_msg);
            if ($parameters_ok) {
                if ($position_valeur == -1) {
                    $parameters_ok = $this->parseValeur(1, $valeur, $report_msg);
                } else {
                    $parameters_ok = $this->parseValeur($row_tab[$position_valeur], $valeur, $report_msg);
                }
            }
        }

        if ($parameters_ok) {
            $report_msg = "succès importation";
            $parameters_result = 1;
        }
        $this->addToReport($row_current,$report_msg, $parameters_result);
        return $parameters_ok;
    }
}
