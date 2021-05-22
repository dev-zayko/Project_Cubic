<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoConstruccion;

class TipoConstruccionController extends Controller{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datosTP = TipoConstruccion::all();
        return response()->json([
            "Estado" => true,
            "Mensaje" => "Lista de Servicios",
            "data" => $datosSE
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function crear(Request $request)
    {
        $datosTP = new TipoConstruccion();
        $datosTP->nomTipoCons = $request->nomTipoCons;
        $datosTP->save();
        return response()->json($request);
    }

    public function verID($idTipoConstruccion)
    {
        $datosTP = new TipoConstruccion();
        $datosTP = $datosTP->find($idTipoConstruccion);
        return response()->json($datosTP);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function modificar(Request $request, $idTipoConstruccion)
    {

        $datosTP = TipoUsuario::find($idTipoConstruccion);
        if ($request->input('nomTipoCons')) {
            $datosTP->nomTipoCons = $request->input('nomTipoCons');
        }
        $datosTP->save();

        return response()->json("Registro Actualizado");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function eliminar($idTipoConstruccion)
    {

        $datosTP = TipoUsuario::find($idTipoConstruccion);
        $datosTP->delete();
        return response()->json("Registro Borrado");
    }
}
