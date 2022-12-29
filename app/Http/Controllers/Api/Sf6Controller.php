<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Sf6\StoreSf6Request;
use App\Http\Requests\Api\Sf6\UpdateSf6Request;
use App\Models\Sf6;
use App\Models\User;
use App\Repositories\Sf6Repository;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class Sf6Controller.
 */
class Sf6Controller extends Controller
{
    /**
     * @var Sf6Repository
     */
    protected $sf6Repository;

    /**
     * Sf6Controller constructor.
     *
     * @param  Sf6Repository  $sf6Repository
     */
    public function __construct(Sf6Repository $sf6Repository)
    {
        $this->sf6Repository = $sf6Repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Sf6::class);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sf6 $sf6
     * @return \Illuminate\Http\Response
     */
    public function show(Sf6 $sf6)
    {
        return QueryBuilder::for(Sf6::whereId($sf6->id))->first();
    }

    public function formSf6($id_sf6 = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->sf6Repository->formSf6($id_sf6);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Sf6 instance.
     */
    protected function store(StoreSf6Request $data)
    {
        return $this->sf6Repository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sf6 $sf6
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateSf6Request $request, $sf6)
    {
        return $this->sf6Repository->update($request, $sf6);
    }
}
