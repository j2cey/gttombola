<?php


namespace App\Search\Queries;

use App\Models\Tombola;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class TombolaSearch extends Search
{
    use EloquentSearch;

    /**
     * @inheritDoc
     */
    protected function query()//: Builder
    {
        $query = Tombola::query();

        if ($this->params->search->hasFilter()) {
            $datecreatedrange = $this->getDateCreatedRangeCrit($this->params->search->search);
            $searchCrit = $this->getSearchCrit($this->params->search->search);
            //dd($searchCrit, $this->params->search->search);
            if ($searchCrit) {
                $query
                    ->where('titre', 'like', '%' . $searchCrit . '%')
                    ->orWhere('description', 'like', '%' . $searchCrit . '%');
            }
            if ($datecreatedrange) {
                $dt_deb = Carbon::createFromFormat('Y-m-d', $datecreatedrange[0])->addDay()->format('Y-m-d');
                $dt_fin = Carbon::createFromFormat('Y-m-d', $datecreatedrange[1])->addDay()->format('Y-m-d');
                $query
                    ->whereBetween('created_at', [$dt_deb,$dt_fin]);
            }
        }

        return $query;
    }

    private function getDateCreatedRangeCrit($search) {
        $search_arr = explode('|', $search);
        $datecreated_range = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "datecreate_du") {
                $datecreated_range[0] = $crit_arr[1];
            } elseif ($crit_arr[0] === "datecreate_au") {
                $datecreated_range[1] = $crit_arr[1];
            }
        }
        return is_null($datecreated_range) ? null : (count($datecreated_range) === 2 ? $datecreated_range : null);
    }

    private function getSearchCrit($search) {
        $search_arr = explode('|', $search);
        $search_crit = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "search") {
                $search_crit = $crit_arr[1];
                break;
            }
        }
        return $search_crit;
    }

    private function getStatutVideoCrit($search) {
        $search_arr = explode('|', $search);
        $statutvideo = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "statutvideos") {
                $statutvideo = $crit_arr[1];
                break;
            }
        }
        return $statutvideo;
    }
}
