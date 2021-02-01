<?php


namespace App\Search;

use App\Search\Payloads\Payload;
use Illuminate\Contracts\Support\Arrayable;

class Params implements Arrayable
{
    /**
     * @var Payload
     */
    public $search;

    /**
     * @var int
     */
    public $perPage;

    /**
     * @var int
     */
    public $page;

    /**
     * @var string
     */
    public $orderBy;


    /**
     * Params constructor.
     *
     * @param Payload $search
     * @param  int $perPage
     * @param  int $page
     * @param  string $orderBy
     */
    public function __construct(Payload $search, int $perPage, int $page, string $orderBy)
    {
        $this->page = $page;
        $this->search = $search;
        $this->perPage = $perPage;
        $this->orderBy = $orderBy;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge([
            'per_page' => $this->perPage,
            'page' => $this->page,
            'order_by' => $this->orderBy,
        ], $this->search->toArray());
    }
}
