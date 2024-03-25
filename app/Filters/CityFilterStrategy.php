<?php

namespace App\Filters;

class CityFilterStrategy implements FilterStrategyInterface
{

    /**
     * filter hotels by city
     * @param array $hotels
     * @param array $params
     * @return array
     */
    public function filter(array $hotels, array $params): array
    {
        $city = $params['city'] ?? null;
        return $city ?
            array_filter($hotels, fn($hotel) => stripos($hotel['city'], $city) !== false)
            : $hotels;
    }
}
