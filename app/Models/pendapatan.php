<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendapatan extends Model
{
    use HasFactory;
    protected $table = 'pendapatan';
        protected $fillable = [
            'tgl','id_unit','pendapatan','kasbon','total'];
}
