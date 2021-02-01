<?php

namespace App\Search\Queries;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserSearch extends Search
{
    use EloquentSearch;

    /**
     * @inheritDoc
     */
    protected function query()//: Builder
    {
        $query = User::query();

        if ($this->params->search->hasFilter()) {
            $query
                ->where('name', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('email', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('username', 'like', '%'.$this->params->search->search.'%');
        }

        return $query;
    }
}
