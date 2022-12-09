<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Artisan::call('passport:install');
        $this->call([
            AislamientoSeeder::class, // TODO::iffy. do this better
            CombustibleSeeder::class,
            ElectricidadSeeder::class,
            EmisionSeeder::class,
            EstiercolSeeder::class,
            ExtintorSeeder::class,
            FertilizanteSeeder::class,
            FermentacionSeeder::class,
            FugaSeeder::class,
            LubricanteSeeder::class,
            PapelSeeder::class,
            ParametroSeeder::class,
            RefrigeranteSeeder::class,
            RolSeeder::class,
            ViajeSeeder::class,
            UsuarioSeeder::class,
        ]);
    }
}
