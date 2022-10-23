<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyDetail;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyDetail::truncate();
  
        $json = file_get_contents(storage_path() . "/company_symbols.json");
        $companyLists = json_decode($json);
  
        foreach ($companyLists as $key => $value) {
            CompanyDetail::create([
                "name" => $value->{'Company Name'},
                "symbol" => $value->Symbol
            ]);
        }
    }
}
