<?php

namespace App\Http\Requests\User;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ISearchFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest  implements ISearchFormRequest
{
    use SearchRequest;

    /**
     * @inheritDoc
     */
    protected function orderByFields(): array
    {
        return ['name', 'email'];
    }

    /**
     * @inheritDoc
     */
    protected function defaultOrderByField(): string
    {
        return 'name';
    }

    protected function getCustomPayload()
    {
        return $this->search;
    }
}
