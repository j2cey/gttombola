<?php


namespace App\Repositories\Eloquent;

use App\Search\Queries\Search;
use App\Search\Queries\TombolaSearch;
use App\Http\Requests\ISearchFormRequest;
use App\Repositories\Contracts\ITombolaRepositoryContract;

class TombolaRepository implements ITombolaRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function search(ISearchFormRequest $request): Search
    {
        return new TombolaSearch(
            $request->requestParams(), $request->requestOrder()
        );
    }
}
