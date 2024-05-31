<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_kota = file_get_contents(base_path('/database/kota.json'));
        $data_kota = json_decode($file_kota, true);
        $file_kabupaten = file_get_contents(base_path('/database/kabupaten.json'));
        $data_kabupaten = json_decode($file_kabupaten, true);
        City::insert($data_kota);
        City::insert($data_kabupaten);
    }
}
