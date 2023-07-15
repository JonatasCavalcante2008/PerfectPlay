<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_clientes extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cliente',
        'nome',
        'cpf',
        'celular',
        'status'
    ];
}
