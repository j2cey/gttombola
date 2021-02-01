<?php


namespace App\Traits\Report;


trait ReportableTrait
{
    /**
     * Ajoute une ligne au tableau de rapport
     * @param $row_current
     * @param $msg
     * @param $result
     */
    private function addToReport($row_current, $msg, $result) {
        /**
         * La ligne de rapport est un tableau dont la Structure est:
         * [    0 => [] liste de ligne(s) affectée(s),
         *      1 => résultat (-1: échec, 0: rien ne s'est passé, 1: succès)
         *      2 => message
         *      3 => nombre de ligne(s) affectée(s)
         * ]
         */
        if ( empty($msg) ) {
          $msg = "EMPTY REPORT MSG";
        }

        if ( empty($this->report) ) {
            $this->report = json_encode([ [[$row_current],$result,$msg,1],]);
        } else {
            $report_tab = json_decode($this->report);
            $msg_found = false;
            for ($i = 0; $i < count($report_tab); $i++) {
                if (strpos($report_tab[$i][2], $msg) !== false) {
                    $key = -1;
                    if (! $this->getReportLineKey($row_current, $report_tab[$i][0], $key)) {
                        $report_tab[$i][0][] = $row_current;
                        $report_tab[$i][3] = $report_tab[$i][3] + 1;
                    }
                    $msg_found = true;
                    break;
                }
            }

            if (!$msg_found) {
                $report_tab[] = [[$row_current],$result,$msg,1];
            }
            $this->report = json_encode($report_tab);
        }
    }

    private function getReportLineKey($line, $reportline_tab, &$key) {
        $key = -1;
        foreach ($reportline_tab as $curr_key => $curr_val) {
            if ($curr_val == $line) {
                $key = $curr_key;
                return true;
            }
        }
        return false;
    }

    private function getReportLine($line, &$report_line, $remove = false) {
        $report_line = "";
        if (empty($this->report)) {
            $report_line = "";
            return false;
        } else {
            $report_tab = json_decode($this->report);
            for ($i = 0; $i < count($report_tab); $i++) {
                $key = -1;
                if ($this->getReportLineKey($line, $report_tab[$i][0], $key)) {
                    $report_line = $report_tab[$i];
                    if ($remove) {
                        $line_count = (int)$report_tab[$i][3];
                        if ($line_count > 1) {
                            // si la ligne de rapport compte plus de 1 entrées affectées ...
                            // on retire l'entrée recue en paramètre
                            array_splice($report_tab[$i][0], $key, 1);
                            $report_tab[$i][3] -= 1;
                        } else {
                            // sinon ...
                            // on retire toute la ligne de rapport
                            array_splice($report_tab, $i, 1);
                        }
                        $this->report = json_encode($report_tab);
                    }
                    return true;
                }
            }
        }
        return false;
    }
}
