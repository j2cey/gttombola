<?php


namespace App\Search;

class OrderBy
{
    /**
     * @var string
     */
    public $field;

    /**
     * @var string
     */
    public $direction;

    /**
     * OrderBy constructor.
     *
     * @param  string $field
     * @param  string $direction
     */
    public function __construct(string $field, string $direction)
    {
        $this->field = $field;
        $this->direction = $direction;
    }
}
