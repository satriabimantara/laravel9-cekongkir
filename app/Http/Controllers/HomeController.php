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
        $data = [
            'origin' => $this->getCity($request->city_origin)->code,
            'destination' => $this->getCity($request->city_destination)->code,
        ];
        if ($couriers) {
            $data = [
                'origin' => $this->getCity($request->city_origin),
                'destination' => $this->getCity($request->city_destination),
                'weight' => 1300,
                'result' => [],
            ];
            foreach ($couriers as $courier) {
                $ongkir = RajaOngkir::ongkosKirim([
                    'origin' => $data['origin']->code,
                    'destination' => $data['destination']->code,
                    'weight' => $data['weight'],
                    'courier' => $courier
                ])->get();
                $data['result'][] = $ongkir;
            }
            return view('cost')->with($data);
        }
        return redirect()->back();
    }


    public function getProvince()
    {
        return Province::pluck('title', 'code');
    }

    public function getCourier()
    {
        return Courier::all();
    }
    public function getCity($code)
    {
        return City::where('code', $code)->first();
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
                ->select('id', 'title', 'code')
                ->limit(5)->get();
        } else {
            $cities = City::orderBy('title', 'asc')
                ->where('title', 'like', '%' . $search . '%')
                ->select('id', 'title', 'code')
                ->limit(5)->get();
        }

        $response  = [];

        foreach ($cities as $city) {
            $response[] = ['id' => $city->code, 'text' => $city->title];
        }

        return json_encode($response);
    }
}
