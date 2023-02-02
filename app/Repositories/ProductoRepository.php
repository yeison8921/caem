<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductoRepository.
 */
class ProductoRepository extends BaseRepository
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function model()
    {
        return Producto::class;
    }


    public function formProducto($tipo, $id_producto)
    {
        $data = [];
        $data['id_producto'] = $id_producto;
        $data['tipo'] = $tipo;
        if ($id_producto != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/producto/form_producto', $data);
    }

    /**
     * @param array $data
     *
     * @return Producto
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Producto
    {
        return DB::transaction(function () use ($data) {
            $producto = Producto::create($data);
            if ($producto) {
                return $producto;
            }

            throw new GeneralException(__('backend_productos.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_producto)
    {
        $producto = Producto::find($id_producto);
        $producto->update($request->all());
        return $producto;
    }
}
