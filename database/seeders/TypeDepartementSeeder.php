<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\TypeDepartement;
use Illuminate\Database\Seeder;

class TypeDepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew('Direction', 'Direction');
        $this->createNew('Division', 'Division');
        $this->createNew('Service', 'Service');
        $this->createNew('Zone', 'Zone');
        $this->createNew('Agence', 'Agence');
    }

    private function createNew($libelle, $tags) {
        TypeDepartement::create(['intitule' => $libelle, 'tags' => $tags,'status_id' => Status::default()->first()->id]);
    }
}
