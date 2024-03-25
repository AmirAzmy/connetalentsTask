<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;
class HotelApiClient
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = 'https://api.npoint.io/dd85ed11b9d8646c5709';
    }

    public function getHotels()
    {
        return Http::get($this->apiUrl);
    }
}
