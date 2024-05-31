<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // load data seeder dari file json
        $file_provinsi = file_get_contents(base_path('/database/provinsi.json'));
        // convert json to array
        $data = json_decode($file_provinsi, true);
        Province::insert($data);
    }
}
