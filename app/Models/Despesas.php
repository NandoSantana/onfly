<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesas extends Model
{
    use HasFactory;

    public $table = 'despesas';

    protected $fillable = [
        'id',
        'descricao',
        'data',
        'valor',
        'user_id'
    ];

}
