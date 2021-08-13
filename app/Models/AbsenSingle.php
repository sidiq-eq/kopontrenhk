<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenSingle extends Model
{
    use HasFactory;
    protected $table = 'absen_single';
    protected $fillable = [
		  'id_karyawan','tgl', 'datang','pulang'
	];
}
