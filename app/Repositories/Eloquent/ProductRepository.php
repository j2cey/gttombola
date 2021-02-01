<?php


namespace App\Repositories\Eloquent;

use App\Search\Queries\Search;
use App\Search\Queries\ProductSearch;
use App\Http\Requests\ISearchFormRequest;
use App\Repositories\Contracts\IProductRepositoryContract;

class ProductRepository implements IProductRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function search(ISearchFormRequest $request): Search
    {
        return new ProductSearch(
            $request->requestParams(), $request->requestOrder()
        );
    }
}
