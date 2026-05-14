<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descripcion', 'curso_id', 'creado_por', 'materia_id', 'fecha_limite'];

    protected $casts = [
        'fecha_limite' => 'datetime',
    ];

    public function vencida(): bool
    {
        return $this->fecha_limite && $this->fecha_limite->isPast();
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function entregas(): HasMany
    {
        return $this->hasMany(TareaEntrega::class);
    }

    public function entregadaPor(int $userId): bool
    {
        return $this->entregas()->where('user_id', $userId)->exists();
    }
}
