<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_pagamentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cliente',
        'id_pagamento',
        'status_pagamento'
    ];
}
