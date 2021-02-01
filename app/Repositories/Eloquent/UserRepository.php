<?php


namespace App\Repositories\Eloquent;

use App\Search\Queries\Search;
use App\Search\Queries\UserSearch;
use App\Http\Requests\ISearchFormRequest;
use App\Repositories\Contracts\IUserRepositoryContract;

class UserRepository implements IUserRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function search(ISearchFormRequest $request): Search
    {
        return new UserSearch(
            $request->requestParams(), $request->requestOrder()
        );
    }
}
