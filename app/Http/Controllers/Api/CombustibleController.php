<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Combustible\StoreCombustibleRequest;
use App\Http\Requests\Api\Combustible\UpdateCombustibleRequest;
use App\Models\Combustible;
use App\Models\User;
use App\Repositories\CombustibleRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class CombustibleController.
 */
class CombustibleController extends Controller
{
    /**
     * @var CombustibleRepository
     */
    protected $combustibleRepository;

    /**
     * CombustibleController constructor.
     *
     * @param  CombustibleRepository  $combustibleRepository
     */
    public function __construct(CombustibleRepository $combustibleRepository)
    {
        $this->combustibleRepository = $combustibleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Combustible::class)->allowedFilters([
            AllowedFilter::exact('tipo'),
        ]);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Combustible $combustible
     * @return \Illuminate\Http\Response
     */
    public function show(Combustible $combustible)
    {
        return QueryBuilder::for(Combustible::whereId($combustible->id))->first();
    }

    public function formCombustible($tipo, $id_combustible = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->combustibleRepository->formCombustible($tipo, $id_combustible);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new combustible instance.
     */
    protected function store(StoreCombustibleRequest $data)
    {
        return $this->combustibleRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Combustible $combustible
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateCombustibleRequest $request, $combustible)
    {
        return $this->combustibleRepository->update($request, $combustible);
    }
}
