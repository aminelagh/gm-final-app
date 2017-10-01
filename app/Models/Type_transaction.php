<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type_transaction extends Model
{
    protected $table = 'type_transactions';
    protected $primaryKey = 'id_type_transaction';

    protected $fillable = [
      'id_type_transaction', 'libelle',
    ];
}
