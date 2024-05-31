<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Courier;
use App\Models\Province;
use Illuminate\Http\Request;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $province = $this->getProvince();
        $courier = $this->getCourier();
        return view('home', compact('province', 'courier'));
    }
    public function store(Request $request)
    {
        $couriers = $request->courier;
        $results = [];
        foreach ($couriers as $courier) {
            $ongkir = RajaOngkir::ongkosKirim([
                'origin'        => $request->city_origin,     // ID kota/kabupaten asal
                'destination'   => $request->city_destination,      // ID kota/kabupaten tujuan
                'weight'        => 1300,    // berat barang dalam gram
                'courier'       => 'jne'    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
            ])->get();
            $results[] = $ongkir;
        }
        return $results;
    }

    public function getProvince()
    {
        return Province::pluck('title', 'code');
    }

    public function getCourier()
    {
        return Courier::all();
    }
    public function getCities($provinceId)
    {
        $cities = City::where('province_code', $provinceId)->pluck('title', 'code');
        return json_encode($cities);
    }
    public function searchCities(Request $request)
    {
        $search = trim($request->search);

        if (empty($search)) {
            $cities = City::orderBy('title', 'asc')
                ->select('id', 'title')
                ->limit(5)->get();
        } else {
            $cities = City::orderBy('title', 'asc')
                ->where('title', 'like', '%' . $search . '%')
                ->select('id', 'title')
                ->limit(5)->get();
        }

        $response  = [];

        foreach ($cities as $city) {
            $response[] = ['id' => $city->id, 'text' => $city->title];
        }

        return json_encode($response);
    }
}
