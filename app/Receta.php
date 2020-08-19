<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    //Campos que se agregaran
    protected $fillable = [
        'titulo', 'preparacion', 'ingredientes', 'imagen', 'categoria_id'
    ];

    //Obtiene la categoria de la receta via KEY FOREING
    public function categoria(){
        return $this->belongsTo(CategoriaReceta::class);
    }

    //Obtiene el usuario o creador de la receta via KEY FOREING
    public function autor(){
        return $this->belongsTo(User::class, 'user_id');
    }

    //Likes que ha recibido una Receta
    public function likes(){
        return $this->belongsToMany(User::class, 'likes_receta');
    }
}
