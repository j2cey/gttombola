<?php


namespace App\Repositories\Contracts;

use App\Search\Queries\Search;
use App\Http\Requests\ISearchFormRequest;

interface IProductRepositoryContract
{
    /**
     * Get instance of Search.
     *
     * @param ISearchFormRequest $request
     * @return Search
     */
    public function search(ISearchFormRequest $request): Search;
}
