<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;



class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return response()->json($user); 
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = FacadesJWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciales invalidas'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }
        
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = FacadesJWTAuth::parseToken()->authenticate()) {
                return response()->json(['Usuario no encontrado'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token ha expirado'], $e->getCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token invalido'], $e->getCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getCode());
        }
       
        return response()->json($user);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'apellidoP' => 'required|string| max:255',
            'apellidoM' => 'required|string| max:255',
            'telefono' => 'required|string| max:12',
            'fecha_nacimiento' => 'required|date',
            'tipousuario_idTipoUsuario' => 'required|int'
           
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'apellidoP' => $request->get('apellidoP'),
            'apellidoM' => $request->get('apellidoM'),
            'telefono' => $request->get('telefono'),
            'fecha_nacimiento' => $request->get('fecha_nacimiento'),
            'tipousuario_idTipoUsuario' => $request->get('tipousuario_idTipoUsuario')
        ]);

        $token = FacadesJWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }
}

