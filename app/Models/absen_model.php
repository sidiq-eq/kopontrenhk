<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absen_model extends Model
{
    protected $table = 'absen';
    protected $fillable = [
		  'id_karyawan', 'waktu','tgl', 'ket','lokasi','foto',
	];

}
