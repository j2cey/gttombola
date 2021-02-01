<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\SearchCollection;
use App\Http\Requests\User\FetchRequest;
use App\Http\Resources\User as UserResource;
use App\Repositories\Contracts\IUserRepositoryContract;

use Exception;
use \Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * @var IUserRepositoryContract
     */
    private $repository;

    /**
     * UserController constructor.
     *
     * @param IUserRepositoryContract $repository [description]
     */
    public function __construct(IUserRepositoryContract $repository) {
        $this->repository = $repository;
    }

    /**
     * Display products page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('users.index')
            ->with('perPage', new Collection(config('system.per_page')))
            ->with('defaultPerPage', config('system.default_per_page'));
    }

    /**
     * Fetch records.
     *
     * @param  FetchRequest     $request [description]
     * @return SearchCollection          [description]
     */
    public function fetch(FetchRequest $request): SearchCollection
    {
        return new SearchCollection(
            $this->repository->search($request), UserResource::class
        );
    }

    /**
     * [edit description]
     * @param  User $user [description]
     * @return View           [description]
     */
    public function edit(User $user): View {
        $user->load(['ldapaccount','status','roles']);
        return view('users.details')->with('user', $user);
    }

    /**
     * [destroy description]
     * @param  User          $user [description]
     * @return RedirectResponse          [description]
     * @throws Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return new RedirectResponse(route('users'));
    }
}
