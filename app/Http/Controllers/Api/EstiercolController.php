<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Estiercol\StoreEstiercolRequest;
use App\Http\Requests\Api\Estiercol\UpdateEstiercolRequest;
use App\Models\Estiercol;
use App\Models\User;
use App\Repositories\EstiercolRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class EstiercolController.
 */
class EstiercolController extends Controller
{
    /**
     * @var EstiercolRepository
     */
    protected $estiercoleRepository;

    /**
     * EstiercolController constructor.
     *
     * @param  EstiercolRepository  $estiercoleRepository
     */
    public function __construct(EstiercolRepository $estiercoleRepository)
    {
        $this->estiercolRepository = $estiercoleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Estiercol::class)->allowedFilters([
            AllowedFilter::exact('tipo'),
        ]);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estiercol $estiercole
     * @return \Illuminate\Http\Response
     */
    public function show(Estiercol $estiercole)
    {
        return QueryBuilder::for(Estiercol::whereId($estiercole->id))->first();
    }

    public function formEstiercol($tipo, $id_estiercol = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->estiercolRepository->formEstiercol($tipo, $id_estiercol);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Estiercol instance.
     */
    protected function store(StoreEstiercolRequest $data)
    {
        return $this->estiercolRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Estiercol $estiercol
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateEstiercolRequest $request, $estiercol)
    {
        return $this->estiercolRepository->update($request, $estiercol);
    }
}
