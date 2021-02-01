<?php


namespace App\Search\Queries;

use App\Search\Meta;
use App\Search\Params;
use App\Search\OrderBy;

use Illuminate\Support\Collection;

abstract class Search
{
    /**
     * @var OrderBy
     */
    protected $order;

    /**
     * @var Params
     */
    protected $params;

    /**
     * Search constructor.
     *
     * @param Params $params
     * @param OrderBy $order
     */
    public function __construct(Params $params, OrderBy $order)
    {
        $this->order = $order;
        $this->params = $params;
    }

    /**
     * Get request parameters.
     *
     * @return Params
     */
    public function params(): Params
    {
        return $this->params;
    }

    /**
     * Get meta.
     *
     * @return Meta
     */
    public function meta(): Meta
    {
        $total = $this->total();

        $lastPage = $this->lastPage($total);

        if ($lastPage < $this->params->page) {
            $this->params->page = $lastPage;
        }

        return new Meta(
            $total,
            $lastPage,
            $this->prevPage(),
            $this->nextPage($lastPage)
        );
    }

    /**
     * Get total number of records.
     *
     * @return int
     */
    abstract public function total(): int;

    /**
     * Get records.
     *
     * @return Collection
     */
    abstract public function records(): Collection;

    /**
     * Get last page.
     *
     * @param  int $total
     * @return int
     */
    protected function lastPage(int $total): int
    {
        return ceil($total / $this->params->perPage) ?: 1;
    }

    /**
     * Get previous page.
     *
     * @return int|null
     */
    protected function prevPage(): ?int
    {
        return $this->params->page === 1 ? null : $this->params->page - 1;
    }

    /**
     * Get next page.
     *
     * @param  int $lastPage
     * @return int|null
     */
    protected function nextPage(int $lastPage): ?int
    {
        return $this->params->page < $lastPage ? $this->params->page + 1 : null;
    }
}
