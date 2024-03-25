<?php

namespace App\Filters;

class PriceFilterStrategy implements FilterStrategyInterface
{

    /**
     * filter hotels by price range
     * @param array $hotels
     * @param array $params
     * @return array
     */
    public function filter(array $hotels, array $params): array
    {
        $from = $params['price_from'] ?? null;
        $to = $params['price_to'] ?? null;
        return $from && $to ?
            array_filter($hotels, fn($hotel) => $hotel['price'] >= $from && $hotel['price'] <= $to)
            : $hotels;
    }
}
