<?php

namespace Database\Seeders;

use App\Models\Urne;
use Illuminate\Database\Seeder;

class UrneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew("principale",true,"Urne principale contenant tous les participants");
        $this->createNew("AB 060",true,"Urne contenant tous participants dont le numéro commence par 060");
        $this->createNew("AB 062",true,"Urne contenant tous participants dont le numéro commence par 062");
        $this->createNew("AB 065",true,"Urne contenant tous participants dont le numéro commence par 065");
        $this->createNew("AB 066",true,"Urne contenant tous participants dont le numéro commence par 066");
    }

    private function createNew($titre, $urne_automatique, $description) {
        Urne::create([
            'titre' => $titre,
            'urne_automatique' => $urne_automatique,
            'description' => $description,
        ]);
    }
}
