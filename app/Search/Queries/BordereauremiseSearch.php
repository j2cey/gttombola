<?php

namespace App\Search\Queries;

use App\Models\Bordereauremise;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class BordereauremiseSearch extends Search
{
    use EloquentSearch;

    /**
     * @inheritDoc
     */
    protected function query()
    {
        $query = Bordereauremise::query();
        $user = auth()->user();

        //dd($this);

        if ($this->params->search->hasFilter()) {
            $dateremiserange = $this->getDateRemiseRangeCrit($this->params->search->search);
            $localisation = $this->getLocalisationCrit($this->params->search->search);
            $type = $this->getTypeCrit($this->params->search->search);
            $statut = $this->getStatutCrit($this->params->search->search);
            //dd($dateremiserange,$localisation,$statut);
            if ($dateremiserange) {
                $dt_deb = Carbon::createFromFormat('Y-m-d', $dateremiserange[0])->addDay()->format('Y-m-d');
                $dt_fin = Carbon::createFromFormat('Y-m-d', $dateremiserange[1])->addDay()->format('Y-m-d');
                //dd($dt_deb,$dt_fin);
                $query
                    ->whereBetween('date_remise', [$dt_deb,$dt_fin]);
            }
            if ($localisation) {
                $query
                    ->where('bordereauremise_loc_id', $localisation);
            }
            if ($type) {
                $query
                    ->where('bordereauremise_type_id', $type);
            }
            if ($statut) {
                $query
                    ->whereHas('workflowexec', function (Builder $q) use ($statut) {
                        $q->where('current_step_id', $statut);
                    });
                    /*->with('workflowexec', function ($q, $statut) {
                        $q->where('workflowexec.current_step_id', '=', $statut);
                    });*/
            }
            $query->with('localisation');
        }

        return $query;
    }

    private function getDateRemiseRangeCrit($search) {
        $search_arr = explode('|', $search);
        $dateremise_range = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "dateremise_du") {
                $dateremise_range[0] = $crit_arr[1];
            } elseif ($crit_arr[0] === "dateremise_au") {
                $dateremise_range[1] = $crit_arr[1];
            }
        }
        return is_null($dateremise_range) ? null : (count($dateremise_range) === 2 ? $dateremise_range : null);
    }
    private function getLocalisationCrit($search) {
        $search_arr = explode('|', $search);
        $localisation = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "localisation") {
                $localisation = $crit_arr[1];
            }
        }
        return $localisation;
    }

    private function getTypeCrit($search) {
        $search_arr = explode('|', $search);
        $type = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "type") {
                $type = $crit_arr[1];
            }
        }
        return $type;
    }

    private function getStatutCrit($search) {
        $search_arr = explode('|', $search);
        $statut = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "statut") {
                $statut = $crit_arr[1];
            }
        }
        return $statut;
    }
}
