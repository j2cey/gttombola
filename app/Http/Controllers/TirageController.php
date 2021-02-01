<?php

namespace App\Http\Controllers;

use App\Models\Tirage;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Models\UrnePrincipale;
use App\Models\UrneSecondaire;
use Illuminate\Support\Carbon;
use App\Models\ResultatTirage;
use Illuminate\Support\Facades\DB;

class TirageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tirage_start_at = Carbon::now();
        $formInput = $request->all();
        $urnes_tab = $formInput['urnes'];

        sleep(10);

        //dd($formInput, $formInput['urnes'], $request);

        $ids_tires = [];
        $id_urne = 0;

        for ($i = 1; $i <= $formInput['nombre_a_tirer']; $i++) {
            $table_and_id = $this->getTableAndUrneId($urnes_tab[$id_urne]);
            $max = DB::table($table_and_id[0])->where($table_and_id[1], $table_and_id[2])->max('posi');
            $posi_tire = rand(0,$max);
            $ids_tires[] = $this->tirerParticipant($table_and_id,$posi_tire);
        }

        $new_tirage = Tirage::create([
            'titre' => $formInput['titre'],
            'tombola_id' => $formInput['tombola_id'],
            'nombre_a_tirer' => $formInput['nombre_a_tirer'],
            'description' => $formInput['description'],
            'tirage_start_at' => $tirage_start_at,
            'tirage_end_at' => Carbon::now(),
        ]);

        foreach ($ids_tires as $id_tire) {
            $new_tirage->resultats()->save(new ResultatTirage([
                'participant_id' => $id_tire
            ]));
        }

        //$participants_tires = Participant::whereIn('id',$ids_tires)->get();
        //dd($ids_tires,$participants_tires);

        return $new_tirage->load('resultats','resultats.participant');
    }

    private function getTableAndUrneId($uuid) {
        $urne = UrnePrincipale::where('uuid', $uuid)->first();
        if ($urne) {
            // Urne Principale
            return ['participant_urne_principale','urne_principale_id',$urne->id];
        } else {
            // Urne Secondaire
            $urne = UrneSecondaire::where('uuid', $uuid)->first();
            return ['participant_urne_secondaire','urne_secondaire_id',$urne->id];
        }
    }

    private function tirerParticipant($table_and_id,$posi) {
        $posi_tire = DB::table($table_and_id[0])->where($table_and_id[1], $table_and_id[2])
            ->where('posi',$posi)->value('tire');
        $max_posi = DB::table($table_and_id[0])->where($table_and_id[1], $table_and_id[2])->max('posi');

        $final_posi = $posi;
        $next_posi = $posi + 1;

        while ($posi_tire && $next_posi <> $posi) {
            if ($next_posi == $max_posi) {
                $next_posi = 0;
            }
            $posi_tire = DB::table($table_and_id[0])->where($table_and_id[1], $table_and_id[2])
                ->where('posi',$next_posi)->value('tire');
            $final_posi = $next_posi;
            $next_posi++;
        }

        // On marque la posi comme tiré
        DB::table($table_and_id[0])
            ->where($table_and_id[1], $table_and_id[2])
            ->where('posi',$final_posi)->update(['tire' => 1]);
        // On renvoie l'id du participant
        return DB::table($table_and_id[0])
            ->where($table_and_id[1], $table_and_id[2])
            ->where('posi',$final_posi)->value('participant_id');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tirage  $tirage
     * @return \Illuminate\Http\Response
     */
    public function show(Tirage $tirage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tirage  $tirage
     * @return \Illuminate\Http\Response
     */
    public function edit(Tirage $tirage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tirage  $tirage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tirage $tirage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tirage  $tirage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tirage $tirage)
    {
        //
    }
}
