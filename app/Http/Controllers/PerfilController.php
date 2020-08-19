<?php

namespace App\Http\Controllers;

use App\Perfil;
use App\Receta;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        //obtener las recetas con paginacion
        $recetas = Receta::where('user_id', $perfil->user_id)->paginate(4);

        return view('perfiles.show', compact('perfil', 'recetas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {
        //Ejecutar policy
        $this->authorize('view', $perfil);

        return view('perfiles.edit', compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {
        //Ejecutar policy
        $this->authorize('update', $perfil);

        //validar
        $data = request()->validate([
            'nombre' => 'required',
            'url' => 'required',
            'biografia' => 'required'
        ]);

        //Si el usuario sube imagen
        if($request['imagen']){
            //Obtener la ruta de la Imagen
            $ruta_imagen = $request['imagen']->store('upload-perfiles', 'public');

            //Resize de la Imagen
            $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(600, 600);
            $img->save();  
            
            //Crear un arreglo
            $array_imagen = ['imagen' => $ruta_imagen];
        }

        //Asignar nombre y  url
        auth()->user()->url = $data['url'];
        auth()->user()->name = $data['nombre'];
        auth()->user()->save();

        //Asignar biografia y imagen 
            //primero se elimina el url y el nombre de data pesto que no son columnas de perfil
        unset($data['url']);
        unset($data['nombre']);

        //Guardar información
        auth()->user()->perfil()->update(array_merge(
            $data,
            $array_imagen ?? []
        ));
        
        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfil)
    {
        //
    }
}
