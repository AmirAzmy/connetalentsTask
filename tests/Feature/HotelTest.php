<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HotelTest extends TestCase
{
    public function test_list_all_hotels(): void
    {
        $this->get('/api/hotels')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'city',
                    'name',
                    'price',
                    'availability'
                ]
            ]);
    }

    public function test_filter_hotels_by_name(): void
    {
        $this->json('get', '/api/hotels', [
            'name' => 'media one hotel'
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'city',
                    'name',
                    'price',
                    'availability'
                ]
            ])
            ->assertJsonFragment(['name' => 'Media One Hotel']);;
    }

    public function test_filter_hotels_by_city(): void
    {
        $this->json('get', '/api/hotels', [
            'city' => 'paris'
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'city',
                    'name',
                    'price',
                    'availability'
                ]
            ])
            ->assertJsonFragment(['city' => 'paris']);
    }

    public function test_filter_hotels_by_price_range(): void
    {
        $response = $this->json('get', '/api/hotels', [
            'price_from' => 100, 'price_to' => 120
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'city',
                    'name',
                    'price',
                    'availability'
                ]
            ]);
        $hotels = json_decode($response->getContent(), true);

        foreach ($hotels as $hotel) {
            $this->assertGreaterThanOrEqual(100, $hotel['price']);
            $this->assertLessThanOrEqual(120, $hotel['price']);
        }
    }

    public function test_filter_hotels_by_date_range(): void
    {
        $this->json('get', '/api/hotels',
            [
                'date_start' => '01-10-2023',
                'date_end'   => '05-10-2023'
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'city',
                    'name',
                    'price',
                    'availability'
                ]
            ])->assertJson(function ($hotels) {
                $startDate = strtotime('01-10-2023');
                $endDate = strtotime('05-10-2023');
                $availableWithinRange = false;
                foreach ($hotels as $hotel) {
                    foreach ($hotel['availability'] as $availability) {
                        $from = strtotime($availability['from']);
                        $to = strtotime($availability['to']);
                        if ($from <= $endDate && $to >= $startDate) {
                            $availableWithinRange = true;
                            break 2;
                        }
                    }
                }
                return $availableWithinRange;
            });
    }

    public function test_sort_hotels_by_name(): void
    {
        $response = $this->json('get', '/api/hotels', [
            'sort_by' => 'name', 'sort_type' => 'desc'
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'city',
                    'name',
                    'price',
                    'availability'
                ]
            ]);
        $hotelNames = collect($response->getContent())->pluck('name')->toArray();
        $sortedNames = $hotelNames;
        sort($sortedNames);
        $this->assertEquals($sortedNames, $hotelNames);
    }

    public function test_sort_hotels_by_price(): void
    {
        $response = $this->json('get', '/api/hotels', [
            'sort_by' => 'price', 'sort_type' => 'asc'
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'city',
                    'name',
                    'price',
                    'availability'
                ]
            ]);
        $hotelPrices = collect($response->getContent())->pluck('price')->toArray();
        $sortedPrices = $hotelPrices;
        sort($sortedPrices, SORT_NUMERIC);
        $this->assertEquals($sortedPrices, $hotelPrices);
    }

    public function test_filter_hotels_by_multiple_criteria(): void
    {
        $response = $this->json('get', '/api/hotels', [
            'sort_by'    => 'price', 'sort_type' => 'asc',
            'price_from' => 100, 'price_to' => 120,
            'city'       => 'dubai'

        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'city',
                    'name',
                    'price',
                    'availability'
                ]
            ])
            ->assertJsonFragment(['city' => 'dubai']);

        $hotels = json_decode($response->getContent(), true);

        foreach ($hotels as $hotel) {
            $this->assertGreaterThanOrEqual(100, $hotel['price']);
            $this->assertLessThanOrEqual(120, $hotel['price']);
        }

        $hotelPrices = collect($response->getContent())->pluck('price')->toArray();
        $sortedPrices = $hotelPrices;
        sort($sortedPrices, SORT_NUMERIC);
        $this->assertEquals($sortedPrices, $hotelPrices);
    }
}
