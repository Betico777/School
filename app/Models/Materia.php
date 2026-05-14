<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion'];

    public function profesores(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'profesor_materia');
    }

    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class);
    }
}
