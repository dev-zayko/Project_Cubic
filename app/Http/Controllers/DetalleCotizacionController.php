<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleCotizacion;

class DetalleCotizacionController extends Controller{

 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datosDC = DetalleCotizacion::all();
        return response()->json($datosDC); 
    }
/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function crear(Request $request)
{
    $datosDC = new DetalleCotizacion();
    $datosDC->cubicacion_idCubica = $request->cubicacion_idCubica;
    $datosDC->material_idMaterial = $request->material_idMaterial;
    $datosDC->users_id = $request->users_id;
    $datosDC->fecha_creacion = $request->fecha_creacion;

    $datosDC->save();
    return response()->json($request);
}

public function verID($idDetalleCoti)
{
   $datosDC = DetalleCotizacion::find($idDetalleCoti);
    return response()->json($datosDC);
}
/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Models\Project  $project
 * @return \Illuminate\Http\Response
 */
public function modificar(Request $request, $idDetalleCoti)
{

    $datosDC = DetalleCotizacion::find($idDetalleCoti);
    if ($request->input('cubicacion_idCubica') ||
    $request->input('material_idMaterial') ||
    $request->input('users_id') ||
    $request->input('fecha_creacion')) {

        $datosDC->cubicacion_idCubica = $request->input('cubicacion_idCubica');
        $datosDC->material_idMaterial = $request->input('material_idMaterial');
        $datosDC->users_id = $request->input('users_id');
        $datosDC->fecha_creacion = $request->input('fecha_creacion');
    }
    $datosDC->save();

    return response()->json("Registro Actualizado");
}
/**
 * Remove the specified resource from storage.
 *
 * @param  \App\Models\Project  $project
 * @return \Illuminate\Http\Response
 */
public function eliminar($idDetalleCoti)
{

    $datosDC = DetalleCotizacion::find($idDetalleCoti);
    $datosDC->delete();
    return response()->json("Registro Borrado");
}
}