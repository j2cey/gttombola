<?php


namespace App\Search;

use Illuminate\Contracts\Support\Arrayable;

class Meta implements Arrayable
{
    /**
     * @var int
     */
    public $total;

    /**
     * @var int
     */
    public $lastPage;

    /**
     * @var int|null
     */
    public $prevPage;

    /**
     * @var int|null
     */
    public $nextPage;

    /**
     * Meta constructor.
     *
     * @param  int $total
     * @param  int $lastPage
     * @param  int|null $prevPage
     * @param  int|null $nextPage
     */
    public function __construct(
        int $total,
        int $lastPage,
        int $prevPage = null,
        int $nextPage = null
    )
    {
        $this->total = $total;
        $this->lastPage = $lastPage;
        $this->prevPage = $prevPage;
        $this->nextPage = $nextPage;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'prev_page' => $this->prevPage,
            'next_page' => $this->nextPage,
            'last_page' => $this->lastPage,
        ];
    }
}
