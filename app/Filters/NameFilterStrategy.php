<?php

namespace App\Filters;

class NameFilterStrategy implements FilterStrategyInterface
{

    /**
     * filter hotels by name
     * @param array $hotels
     * @param array $params
     * @return array
     */
    public function filter(array $hotels, array $params): array
    {
        $name = $params['name'];
        return $name ?
            array_filter($hotels, fn($hotel) => stripos($hotel['name'], $name) !== false)
            : $hotels;
    }
}
