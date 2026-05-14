<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TareaEntrega extends Model
{
    public $timestamps = false;

    protected $fillable = ['tarea_id', 'user_id', 'entregado_at'];

    protected $casts = [
        'entregado_at' => 'datetime',
    ];

    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class);
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
