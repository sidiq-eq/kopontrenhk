<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class konsinyasi extends Model
{
    use HasFactory;
    protected $table = 'konsinyasi';
        protected $fillable = [
            'tgl','id_unit','total','total'];
}
