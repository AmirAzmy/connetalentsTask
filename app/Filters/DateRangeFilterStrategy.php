<?php

namespace App\Filters;

class DateRangeFilterStrategy implements FilterStrategyInterface
{
    /**
     * filter hotels by date range
     * @param array $hotels
     * @param array $params
     * @return array
     */
    public function filter(array $hotels, array $params): array
    {
        $start = strtotime($params['date_start']) ?? null;
        $end = strtotime($params['date_end']) ?? null;

        return $start && $end ?
            array_filter($hotels, function($hotel) use ($start, $end) {
                foreach ($hotel['availability'] as $availability){
                    $from = strtotime($availability['from']);
                    $to = strtotime($availability['to']);
                    if ($from <= $end && $to >= $start) {
                        return true; // Availability overlaps with date range
                    }
                }
                return false; // No matching availability found for this hotel
            })
            : $hotels;
    }
}
