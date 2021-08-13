<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin;
use App\Models\AbsenSingle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportNama implements FromView,WithHeadings
{
    protected $nama;
    protected $bulan;
    protected $tahun;

    public function headings():array{
        return [
            'Berikut Data Absen',
            
        ];
    }
    function __construct($nama,$bulan,$tahun)
    {
        $this->nama = $nama;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return DB::table('absen_single')
    //     ->join('karyawan','karyawan.id_karyawan','=','absen_single.id_karyawan')
    //     ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
    //     ->whereMonth('tgl', $this->bulan)
    //     ->whereYear('tgl',$this->tahun)
    //     ->where('karyawan.id_unit','=',$this->unit)
    //     ->orderBy('absen_single.tgl','asc')
    //     ->get();
    // }
    public function view(): View
    {
        return view('admin/export_nama', [
            'data_absen' => DB::table('absen_single')
            ->join('karyawan','karyawan.id_karyawan','=','absen_single.id_karyawan')
            ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
            ->whereMonth('tgl', $this->bulan)
            ->whereYear('tgl',$this->tahun)
            ->where('absen_single.id_karyawan','=',$this->nama)
            ->orderBy('absen_single.tgl','asc')
            ->get()
        ]);
    }
}
