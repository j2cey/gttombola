<?php

namespace Database\Seeders;

use App\Models\TypeUrne;
use Illuminate\Database\Seeder;

class TypeUrneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew("Principale", "all_select", "Urne contenant tous les numéros.");
        $this->createNew("Selection par Numéro", "num_select", "Urne de numéros sélectionnés par AB.");
    }

    private function createNew($titre, $code, $description) {
        TypeUrne::create([
            'titre' => $titre,
            'code' => $code,
            'description' => $description,
        ]);
    }
}
