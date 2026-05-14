<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'activo'];

    public function estudiantes(): HasMany
    {
        return $this->hasMany(User::class, 'curso_id');
    }

    public function profesores(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'profesor_curso');
    }

    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class);
    }
}
