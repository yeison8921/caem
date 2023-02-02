<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Producto\StoreProductoRequest;
use App\Http\Requests\Api\Producto\UpdateProductoRequest;
use App\Models\Producto;
use App\Models\User;
use App\Repositories\ProductoRepository;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Class ProductoController.
 */
class ProductoController extends Controller
{
    /**
     * @var ProductoRepository
     */
    protected $productoRepository;

    /**
     * ProductoController constructor.
     *
     * @param  ProductoRepository  $productoRepository
     */
    public function __construct(ProductoRepository $productoRepository)
    {
        $this->productoRepository = $productoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Producto::class)->allowedFilters([
            AllowedFilter::exact('tipo'),
            AllowedFilter::exact('subtipo'),
        ]);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        return QueryBuilder::for(Producto::whereId($producto->id))->first();
    }

    public function formProducto($tipo, $id_producto = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->productoRepository->formProducto($tipo, $id_producto);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Producto instance.
     */
    protected function store(StoreProductoRequest $data)
    {
        return $this->productoRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto $producto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductoRequest $request, $producto)
    {
        return $this->productoRepository->update($request, $producto);
    }
}
