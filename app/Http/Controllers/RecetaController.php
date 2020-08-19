<?php

namespace App\Http\Controllers;

use App\CategoriaReceta;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{

    public function __construct(){
        $this->middleware('auth', ['except' => ['show', 'search']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Aqui me traigo el usuario
        //$usuario = auth()->user();

        //Aquí estoy trayendome las recetas del usuario que inicio Sesión
        //$recetas = Auth::user()->recetas;

        $usuario = auth()->user();



        //Recetas con paginación
        $recetas = Receta::where('user_id', $usuario->id)->paginate(4);

        return view('recetas.index')->with('recetas', $recetas)->with('usuario', $usuario);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Obtener categorias (Sin modelo)
        //$categorias = DB::table('categoria_recetas')->get()->pluck('nombre', 'id');

        //Con modelo
        $categorias = CategoriaReceta::all(['id', 'nombre']);
        return view('recetas.create')->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validando
        $data = $request->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'required|image',
            'preparacion' => 'required',
        ]);

        //Obtener la ruta de la Imagen
        $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');

        //Resize de la Imagen
        $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(1200, 550);
        $img->save();

        //Guardando receta de un usuario (Sin Modelo)
        /*
        DB::table('recetas')->insert([
            'titulo' => $data['titulo'],
            'ingredientes' => $data['ingredientes'],
            'preparacion' => $data['preparacion'],
            'imagen' => $ruta_imagen,
            'user_id' => Auth::user()->id,
            'categoria_id' => $data['categoria'],
        ]);*/

        //gUARDANDO LA RECETA CON MODELO
        auth()->user()->recetas()->create([
            'titulo' => $data['titulo'],
            'ingredientes' => $data['ingredientes'],
            'preparacion' => $data['preparacion'],
            'imagen' => $ruta_imagen,
            'categoria_id' => $data['categoria'],
        ]);

        return redirect()->action('RecetaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        //obtener si al usuario actual le gusta l a receta y esta autenticado
        $like = ( auth()->user() ) ? auth()->user()->meGusta->contains($receta->id) : false;

        //Pasa la cantidad de likes a la vista
        $likes = $receta->likes->count();

        return view('recetas.show')
                ->with('receta', $receta)
                ->with('like', $like)
                ->with('likes', $likes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        //Revisar el policy
        $this->authorize('view', $receta);
        
        $categorias = CategoriaReceta::all(['id', 'nombre']);
        return view('recetas.edit', compact('categorias', 'receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        //Revisa el policy
        $this->authorize('update', $receta);

        //validando
        $data = $request->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'ingredientes' => 'required',
            'preparacion' => 'required',
        ]);
        
        //Asignar valores
        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];

        //Si el usuario sube una nueva imagen
        if(request('imagen')){
            //Obtener la ruta de la Imagen
            $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');

            //Resize de la Imagen
            $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(1200, 550);
            $img->save();

            $receta->imagen = $ruta_imagen;
        }
        $receta->save();

        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        //Ejecutar el policy
        $this->authorize('delete', $receta);

        //
        $receta->delete();
        return redirect()->action('RecetaController@index');
    }


    public function search(Request $request)
    {
        $busqueda = $request['buscar'];
        $recetas = Receta::where('titulo', 'like', '%' . $busqueda . '%')->paginate(3);
        $recetas->appends(['buscar' => $busqueda]);

        return view('busquedas.show', compact('recetas', 'busqueda'));
    }
}
