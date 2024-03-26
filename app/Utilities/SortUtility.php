<?php

namespace App\Utilities;

class SortUtility
{
    /**
     * sort nested array
     * @param array $data
     * @param string|null $sortBy
     * @param string|null $sortDirection
     * @return array
     */
    static function sort(array $data, string|null $sortBy = 'name', string|null $sortDirection = 'asc'): array
    {
        $sortBy = $sortBy ?? 'name';
        // Default sort type is ascending
        $sortType = strtolower($sortDirection) === 'desc' ? SORT_DESC : SORT_ASC;

        // Extract the values of the specified field to prepare for sorting
        $values = array_column($data, $sortBy);
        // Perform the sorting based on the specified field and sort type
        array_multisort($values, $sortType, $data);

        return $data;
    }
}
