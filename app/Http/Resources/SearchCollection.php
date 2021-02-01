<?php

namespace App\Http\Resources;

use App\Search\Meta;
use App\Search\Params;
use App\Search\Queries\Search;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchCollection extends ResourceCollection
{
    /**
     * @var Meta
     */
    private $meta;

    /**
     * @var Params
     */
    private $params;

    /**
     * SearchCollection constructor.
     *
     * @param Search $search
     * @param  string $collects
     */
    public function __construct(Search $search, string $collects)
    {
        $this->collects = $collects;
        $this->meta = $search->meta();
        $this->params = $search->params();

        parent::__construct($search->records());
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'records' => $this->collection,
            'params' => $this->params->toArray(),
            'meta' => $this->meta->toArray(),
        ];
    }
}
