<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Tombola;
use Illuminate\Http\Request;
use App\Models\ParametreParticipation;
use App\Http\Resources\SearchCollection;
use App\Http\Requests\Tombola\FetchRequest;
use App\Http\Resources\Tombola as TombolaResource;
use App\Http\Requests\Tombola\CreateTombolaRequest;
use App\Repositories\Contracts\ITombolaRepositoryContract;

use Exception;
use \Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;

class TombolaController extends Controller
{
    /**
     * @var ITombolaRepositoryContract
     */
    private $repository;

    /**
     * ParticipantController constructor.
     *
     * @param ITombolaRepositoryContract $repository [description]
     */
    public function __construct(ITombolaRepositoryContract $repository) {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuts = Status::all();
        return view('tombolas.index')
            ->with('perPage', new Collection(config('system.per_page')))
            ->with('defaultPerPage', config('system.default_per_page'))
            ->with('statuts', $statuts);
    }

    /**
     * Fetch records.
     *
     * @param  FetchRequest     $request [description]
     * @return SearchCollection          [description]
     */
    public function fetch(FetchRequest $request)
    {
        return new SearchCollection(
            $this->repository->search($request), TombolaResource::class
        );
    }

    public function getUrnes($tombola_id) {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tombolas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTombolaRequest $request)
    {
        $formInput = $request->all();

        //dd($formInput, $request);

        $data = [
            'titre' => $formInput['titre'],
            'description' => $formInput['description'],
        ];

        $new_tombola = Tombola::create($data);

        $parametreparticipation = new ParametreParticipation([
            'separateur_colonnes' => $formInput['separateur_colonnes'],
            'position_numero' => $formInput['position_numero'],
            'position_valeur' => $formInput['position_valeur'],
            'participation_unique' => $request->getCheckValue('participation_unique'),
        ]);

        if (! is_null($formInput['participation_unite'])) { $parametreparticipation->participation_unite = $formInput['participation_unite']; }
        if (! is_null($formInput['participation_valeurunitaire'])) { $parametreparticipation->participation_valeurunitaire = $formInput['participation_valeurunitaire']; }

        /**
         * Enregistrement des paramètres de Participations
         */
        $new_tombola->parametreparticipation()->save($parametreparticipation);

        //verifyAndStoreFile( Request $request, $fieldname_rqst, $fieldname_db, $directory = 'unknown', $oldimage = ' ' )
        $new_tombola->verifyAndStoreFile($request, 'fichier_reglement', 'fichier_reglement', 'tombolas_reglements_dir');

        $new_tombola->createAutomaticsUrnes();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tombola  $tombola
     * @return \Illuminate\Http\Response
     */
    public function show(Tombola $tombola)
    {
        $tombola = Tombola::find($tombola->id);
        $tombola
            ->load('urneprincipales','urnesecondaires')
            //->loadCount('urneprincipales.participants','urneprincipales.participations','urnesecondaires.participants','urnesecondaires.participations')
            //->load(['urneprincipales' => function ($query) {$query->withCount(['participants','participations']);}])
            //->load(['urnesecondaires' => function ($query) {$query->withCount(['participants','participations']);}])
            //->load('urneprincipales.typeurne','urneprincipales.participants','urneprincipales.participations','urnesecondaires.typeurne','urnesecondaires.participants','urnesecondaires.participations')
        ;
        //dd($tombola);
        return view('tombolas.show')
            ->with('tombola', $tombola);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tombola  $tombola
     * @return \Illuminate\Http\Response
     */
    public function edit(Tombola $tombola)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tombola  $tombola
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tombola $tombola)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tombola  $tombola
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tombola $tombola)
    {
        //
    }
}
