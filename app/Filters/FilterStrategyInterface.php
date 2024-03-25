<?php

namespace App\Filters;

interface FilterStrategyInterface
{
    /**
     * filter hotels data
     * @param array $hotels
     * @param array $params
     * @return array
     */
    public function filter(array $hotels, array $params):array;
}
