<?php

namespace Database\Seeders;


use App\Models\Knowledge_area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Knowledge_areaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programacion = new Knowledge_area();
        $programacion->name = 'Programación';
        $programacion->save();

        $ciencias = new Knowledge_area();
        $ciencias->name = 'Ciencias';
        $ciencias->save();
    }
}
