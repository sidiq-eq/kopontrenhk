<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class amanah extends Model
{
        use HasFactory;
        protected $table = 'amanah';
        protected $fillable = [
            'nama_amanah','id_unit'];

}
