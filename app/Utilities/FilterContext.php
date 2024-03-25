<?php

namespace App\Utilities;


use App\Filters\FilterStrategyInterface;

class FilterContext
{
    private array $strategies = [];

    /**
     * add filter strategy
     * @param FilterStrategyInterface $filterStrategy
     * @return void
     */
    public function addStrategy(FilterStrategyInterface $filterStrategy): void
    {
        $this->strategies[] = $filterStrategy;
    }

    /**
     * implement all strategies
     * @param array $hotels
     * @param array $params
     * @return array
     */
    public function apply(array $hotels, array $params)
    {
        foreach ($this->strategies as $strategy) {
            $hotels = $strategy->filter($hotels, $params);
        }
        return array_values($hotels);
    }
}
