<?php

namespace App\Http\Controllers;

use App\Clients\HotelApiClient;
use App\Filters\CityFilterStrategy;
use App\Filters\DateRangeFilterStrategy;
use App\Filters\NameFilterStrategy;
use App\Filters\PriceRangeFilterStrategy;
use App\Http\Requests\HotelRequest;
use App\Utilities\FilterContext;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    private $hotelApiClient;

    public function __construct(HotelApiClient $hotelApiClient)
    {
        $this->hotelApiClient = $hotelApiClient;
    }

    /**
     * fetch and filter hotels data
     * @param HotelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(HotelRequest $request)
    {
        //fetch hotels data
        $hotels = $this->hotelApiClient->getHotels();
        //add filter
        $filterContext = new FilterContext();
        $filterContext->addStrategy(new NameFilterStrategy());
        $filterContext->addStrategy(new PriceRangeFilterStrategy());
        $filterContext->addStrategy(new CityFilterStrategy());
        $filterContext->addStrategy(new DateRangeFilterStrategy());
        //execute all filters
        $hotels=$filterContext->apply($hotels,$request->only([
            'name','price_from','price_to','city','date_start','date_end'
        ]));


        return response()->json($hotels);
    }
}
