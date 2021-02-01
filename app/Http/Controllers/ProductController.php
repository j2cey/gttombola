<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\SearchCollection;
use App\Http\Requests\Product\FetchRequest;
use App\Http\Resources\Product as ProductResource;
use App\Repositories\Contracts\IProductRepositoryContract;

use Exception;
use \Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * @var IProductRepositoryContract
     */
    private $repository;

    /**
     * ProductController constructor.
     *
     * @param IProductRepositoryContract $repository [description]
     */
    public function __construct(IProductRepositoryContract $repository) {
        $this->repository = $repository;
    }

    /**
     * Display products page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('product.index')
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
            $this->repository->search($request), ProductResource::class
        );
    }

    /**
     * [edit description]
     * @param  Product $product [description]
     * @return View           [description]
     */
    public function edit(Product $product): View {
        return view('product.edit')->with('product', $product);
    }

    /**
     * [destroy description]
     * @param  Product          $product [description]
     * @return RedirectResponse          [description]
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return new RedirectResponse(route('product'));
    }
}
