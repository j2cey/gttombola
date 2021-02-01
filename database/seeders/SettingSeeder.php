<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // groupe app_name, id: 1
        $this->createNew("app_name", null, "Moov-Africa Tombolas", "string", ",", "Application Name.");
        // groupe files, id: 2
        $this->createNew("files", null, null, null, ",", "settings Files.");
        // sub groupe files.uploads, id: 3
        $this->createNew("uploads", 2, null, null, ",", "Uploads.");
        // sub groupe files.uploads.max_size, id: 4
        $this->createNew("max_size", 3, null, null, ",", "Max Size.");
        $this->createNew("any", 4, "70", "integer", ",", "Max any file size.");
        $this->createNew("video", 4, "70", "integer", ",", "Max video file size.");

        // groupe tombola, id: 7
        $this->createNew("tombola", null, null, null, ",", "settings Tombola.");
        // sub groupe tombola.urnes, id: 8
        $this->createNew("urnes", 7, null, null, ",", "Settings Tombola Urnes.");
        // sub groupe tombola.urnes.automatics, id: 9
        $this->createNew("automatics", 8, null, null, ",", "Settings Tombola Urnes - Automatics.");
        // sub groupe tombola.urnes.automatics.principale, id: 10
        $this->createNew("principale", 9, null, null, ",", "Principale automatics urnes.");
        $this->createNew("01", 10, "Principale|all_select|XXX|Urne principale contenant tous les participants", "array", "|", "automatic urne 01.");
        // sub groupe tombola.urnes.automatics.secondaire, id: 12
        $this->createNew("secondaire", 9, null, null, ",", "Secondaire automatics urnes.");
        $this->createNew("01", 12, "AB 060|num_select|060|Urne contenant tous participants dont le numéro commence par 060", "array", "|", "automatic urne 02.");
        $this->createNew("02", 12, "AB 062|num_select|062|Urne contenant tous participants dont le numéro commence par 062", "array", "|", "automatic urne 03.");
        $this->createNew("03", 12, "AB 065|num_select|065|Urne contenant tous participants dont le numéro commence par 065", "array", "|", "automatic urne 04.");
        $this->createNew("04", 12, "AB 066|num_select|066|Urne contenant tous participants dont le numéro commence par 066", "array", "|", "automatic urne 05.");
    }

    private function createNew($name, $group_id = null, $value = null, $type = null, $array_sep = ",", $description = null) {
        $data = ['name'  => $name, 'array_sep' => $array_sep];
        if (! is_null($group_id)) { $data['group_id'] = $group_id; }
        if (! is_null($value)) { $data['value'] = $value; }
        if (! is_null($type)) { $data['type'] = $type; }
        if (! is_null($description)) { $data['description'] = $description; }
        Setting::create($data);
    }
}
