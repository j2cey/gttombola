<?php

namespace App\Http\Requests\Tombola;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ISearchFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest  implements ISearchFormRequest
{
    use SearchRequest;

    /**
     * @inheritDoc
     */
    protected function orderByFields() : array
    {
        return ['id', 'titre'];
    }

    /**
     * @inheritDoc
     */
    protected function defaultOrderByField() : string
    {
        return 'id';
    }

    protected function getCustomPayload()
    {
        $payload = "";
        $payload = $this->addToPayload($payload, 'search', $this->search);
        $payload = $this->addToPayload($payload, 'datecreate_du', substr($this->datecreate_du, 0, 10));
        $payload = $this->addToPayload($payload, 'datecreate_au', substr($this->datecreate_au, 0, 10));

        return $payload;
    }
}
