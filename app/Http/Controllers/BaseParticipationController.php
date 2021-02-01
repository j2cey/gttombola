<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BaseParticipation;
use App\Models\BaseParticipationSubfile;
use App\Http\Requests\BaseParticipation\CreateBaseParticipationRequest;

class BaseParticipationController extends Controller
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
    public function store(CreateBaseParticipationRequest $request)
    {
        $formInput = $request->all();

        //dd($formInput, $request);

        $data = [
            'tombola_id' => $formInput['tombola_id'],
            'separateur_colonnes' => $formInput['separateur_colonnes'],
            'entete_premiere_ligne' => $request->getCheckValue('entete_premiere_ligne'),
            'vider_urnes' => $request->getCheckValue('vider_urnes'),
        ];

        $new_baseparticipation = BaseParticipation::create($data);

        //verifyAndStoreFile( Request $request, $fieldname_rqst, $fieldname_db, $directory = 'unknown', $oldimage = ' ' )
        $new_baseparticipation->verifyAndStoreFile($request, 'fichier', 'fichier', 'tombolas_participations_dir');

        //splitFileIntoSubfiles($from_dir, $from_file, $to_dir, $subfile_max_line,$entete_premiere_ligne = false)
        $subfiles = $new_baseparticipation->splitFileIntoSubfiles('tombolas_participations_dir', $new_baseparticipation->fichier, 'tombolas_participations_subfiles_dir', 500, $new_baseparticipation->entete_premiere_ligne);
        foreach ($subfiles as $subfile) {
            $new_baseparticipation->subfiles()->save(
                new BaseParticipationSubfile(
                    [
                        'name' => $subfile['name'],
                        'nb_rows' => $subfile['nb_rows'],
                        'report' => json_encode([]),
                    ]
                )
            );
        }
        $new_baseparticipation->setImportResult();
        $new_baseparticipation->tombola->setImportResult();

        // Vider Urnes
        if ($new_baseparticipation->vider_urnes) {
            // Urnes Principales
            $new_baseparticipation->tombola->urneprincipales[0]->participations()->detach();
            // Urnes secondaires
            for ($j = 0; $j < count($new_baseparticipation->tombola->urnesecondaires); $j++) {
                $new_baseparticipation->tombola->urnesecondaires[$j]->participations()->detach();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BaseParticipation  $baseParticipation
     * @return \Illuminate\Http\Response
     */
    public function show(BaseParticipation $baseParticipation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BaseParticipation  $baseParticipation
     * @return \Illuminate\Http\Response
     */
    public function edit(BaseParticipation $baseParticipation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BaseParticipation  $baseParticipation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BaseParticipation $baseParticipation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BaseParticipation  $baseParticipation
     * @return \Illuminate\Http\Response
     */
    public function destroy(BaseParticipation $baseParticipation)
    {
        //
    }
}
