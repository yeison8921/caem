<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Extintor\StoreExtintorRequest;
use App\Http\Requests\Api\Extintor\UpdateExtintorRequest;
use App\Models\Extintor;
use App\Models\User;
use App\Repositories\ExtintorRepository;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class ExtintorController.
 */
class ExtintorController extends Controller
{
    /**
     * @var ExtintorRepository
     */
    protected $extintorRepository;

    /**
     * ExtintorController constructor.
     *
     * @param  ExtintorRepository  $extintorRepository
     */
    public function __construct(ExtintorRepository $extintorRepository)
    {
        $this->extintorRepository = $extintorRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Extintor::class);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Extintor $extintore
     * @return \Illuminate\Http\Response
     */
    public function show(Extintor $extintore)
    {
        return QueryBuilder::for(Extintor::whereId($extintore->id))->first();
    }

    public function formExtintor($id_extintor = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->extintorRepository->formExtintor($id_extintor);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Extintor instance.
     */
    protected function store(StoreExtintorRequest $data)
    {
        return $this->extintorRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Extintor $extintor
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateExtintorRequest $request, $extintor)
    {
        return $this->extintorRepository->update($request, $extintor);
    }
}
