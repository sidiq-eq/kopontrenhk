<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class daftar_unit extends Model
{
    use HasFactory;
        protected $table = 'daftar_unit';
        protected $fillable = [
            'id_unit'];
}
