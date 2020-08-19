<a href="{{route('recetas.create')}}" class="btn btn-outline-primary mr-2 text-uppercase font-weight-bold">
    <svg class="icono" viewBox="0 0 20 20" fill="currentColor" class="book-open w-6 h-6"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path></svg>
    Crear Receta
</a>
<a href="{{route('perfiles.edit', ['perfil' => Auth::user()->id])}}" class="btn btn-outline-success mr-2 text-uppercase font-weight-bold">
    <svg class="icono" viewBox="0 0 20 20" fill="currentColor" class="pencil w-6 h-6"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
    Editar Perfil
</a>
<a href="{{route('perfiles.show', ['perfil' => Auth::user()->id])}}" class="btn btn-outline-info mr-2 text-uppercase font-weight-bold">
    <svg class="icono" viewBox="0 0 20 20" fill="currentColor" class="user-circle w-6 h-6"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path></svg>
    Ver Perfil
</a>