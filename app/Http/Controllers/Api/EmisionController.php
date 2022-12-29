<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Emision\StoreEmisionRequest;
use App\Http\Requests\Api\Emision\UpdateEmisionRequest;
use App\Models\Emision;
use App\Models\User;
use App\Repositories\EmisionRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class EmisionController.
 */
class EmisionController extends Controller
{
    /**
     * @var EmisionRepository
     */
    protected $emisionRepository;

    /**
     * EmisionController constructor.
     *
     * @param  EmisionRepository  $emisionRepository
     */
    public function __construct(EmisionRepository $emisionRepository)
    {
        $this->emisionRepository = $emisionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Emision::class)->allowedFilters([
            AllowedFilter::exact('tipo'),
        ]);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Emision $emisione
     * @return \Illuminate\Http\Response
     */
    public function show(Emision $emisione)
    {
        return QueryBuilder::for(Emision::whereId($emisione->id))->first();
    }

    public function formEmision($tipo, $id_emision = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->emisionRepository->formEmision($tipo, $id_emision);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Emision instance.
     */
    protected function store(StoreEmisionRequest $data)
    {
        return $this->emisionRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Emision $emision
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateEmisionRequest $request, $emision)
    {
        return $this->emisionRepository->update($request, $emision);
    }
}
