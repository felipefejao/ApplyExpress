<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    /** @use HasFactory<\Database\Factories\VagaFactory> */
    use HasFactory;

    protected $table = 'vagas';

    protected $primaryKey = 'id';

    protected $fillable = ['empresa','email', 'recrutador', 'cargo', 'enviado', 'language'];
}
