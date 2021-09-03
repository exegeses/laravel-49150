<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Marca::insert(
            [
                [ 'mkNombre'=>'Nikon' ],
                [ 'mkNombre'=>'Apple' ],
                [ 'mkNombre'=>'Audiotechnica' ],
                [ 'mkNombre'=>'Marshall' ],
                [ 'mkNombre'=>'Samsung' ],
                [ 'mkNombre'=>'Huawei' ]
            ]
        );
    }
}
