<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Supervisor extends Controller
{
    public function beranda(){
        $date = date('y-m-d');
        $session = request()->session()->get('user');
        $tgl = date('y-m-d');
        $data_user = DB::table('users')->where('username','=',$session)->first();
        $user = DB::table('users')->join('unit','unit.id_unit','=','users.id_unit')->where('id',$data_user->id)->first();
        $cek_absen = DB::table('absen')
                    ->join('karyawan','karyawan.id_karyawan','=','absen.id_karyawan')
                    ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                    ->orderBy('absen.waktu','desc')->where('absen.tgl','=', $date)->limit(5)->get();
        $data_pendapatan = DB::table('pendapatan')->orderBy('tgl','desc')->limit(5)->get();
        $data_konsinyasi = DB::table('konsinyasi')->orderBy('tgl','desc')->limit(5)->get();

        //$total = DB::table('pendapatan')->select('total')->where('id_unit',$data_user->id_unit)->limit(7)->get();
        $data = [
            'user'=>$user,
            'pendapatan'=>$data_pendapatan,
            'konsinyasi'=>$data_konsinyasi,
            'absen'=>$cek_absen
            // 'total'=>$total,
            // 'tgl'=>$tgl
        ];
        return view('supervisor/beranda4',$data);
    }
    public function cek_data(){
        $date = date('y-m-d');
        
        $karyawan = DB::table('karyawan')->orderBy('nama', 'asc')->get();
        $unit = DB::table('unit')->join('amanah','amanah.id_unit','=','unit.id_unit')->orderBy('unit.id_unit','asc')->groupBy('unit.id_unit')->get();
        $unit_terdaftar = DB::table('unit')->join('amanah','amanah.id_unit','=','unit.id_unit')->where('status','Terdaftar')->orderBy('unit.id_unit','asc')->groupBy('unit.id_unit')->get();
        $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $valuebulan = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        $tahun = ['2021','2022','2023','2024','2025','2026','2027'];

        $data = [
            'unit'=>$unit,
            'karyawan'=>$karyawan,
            'bulan'=>$bulan,
            'valuebulan'=>$valuebulan,
            'tahun'=>$tahun,
            'terdaftar'=>$unit_terdaftar
        ];
        
        return view('supervisor/cek_data',$data);
    }
    public function semua_data(Request $request){
        $request_unit = $request->unit;
        if($request->id==null){
            $jumlah = '7 Hari Terakhir';
            $tgl = date('y-m-d');
            $data_pendapatan = DB::table('pendapatan')->where('id_unit',$request->unit)->orderBy('tgl','desc')->get();
            $data_konsinyasi = DB::table('konsinyasi')->where('id_unit',$request->unit)->orderBy('tgl','desc')->get();
            $status = DB::table('pendapatan')->where('id_unit',$request->unit)->where('tgl',$tgl)->count();
            $unit = DB::table('unit')->where('id_unit',$request->unit)->first();
            $data_absen = DB::table('absen_single')
                    ->join('karyawan','karyawan.id_karyawan','=','absen_single.id_karyawan')
                    ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                    ->where('karyawan.id_unit','=',$request->unit)
                    ->orderBy('absen_single.tgl','asc')
                    ->get();

            $min = DB::table('pendapatan')->where('id_unit',$request->unit)->latest('tgl')->limit(7)->min('total');
            $max = DB::table('pendapatan')->where('id_unit',$request->unit)->latest('tgl')->limit(7)->max('total');
            $avg = DB::table('pendapatan')->where('id_unit',$request->unit)->latest('tgl')->limit(7)->avg('total');
            $sum = DB::table('pendapatan')->where('id_unit',$request->unit)->latest('tgl')->limit(7)->sum('total');
            $max = number_format($max,0,'','.');
            $min = number_format($min,0,'','.');
            $avg = number_format($avg,0,'','.');
            $sum = number_format($sum,0,'','.');
            $record = DB::table('pendapatan')->where('id_unit',$request->unit)->latest('tgl')->limit(7)->get();
            $record = $record->reverse();
            $data_grafik = [];
            foreach($record as $row){
                $data_grafik['label'][]=date('d/m',strtotime($row->tgl));
                $data_grafik['data'][]=$row->total;

            }
            $min2 = DB::table('konsinyasi')->where('id_unit',$request->unit)->latest('tgl')->limit(7)->min('total');
            $max2 = DB::table('konsinyasi')->where('id_unit',$request->unit)->latest('tgl')->limit(7)->max('total');
            $avg2 = DB::table('konsinyasi')->where('id_unit',$request->unit)->latest('tgl')->limit(7)->avg('total');
            $sum2 = DB::table('konsinyasi')->where('id_unit',$request->unit)->latest('tgl')->limit(7)->sum('total');
            $max2 = number_format($max2,0,'','.');
            $min2 = number_format($min2,0,'','.');
            $avg2 = number_format($avg2,0,'','.');
            $sum2 = number_format($sum2,0,'','.');
            $record2 = DB::table('konsinyasi')->where('id_unit',$request->unit)->latest('tgl')->limit(7)->get();
            $record2 = $record2->reverse();
            $data_grafik2 = [];
            foreach($record2 as $row){
                $data_grafik2['label'][]=date('d/m',strtotime($row->tgl));
                $data_grafik2['data'][]=$row->total;

            }
            $data = [
                'pendapatan'=>$data_pendapatan,
                'konsinyasi'=>$data_konsinyasi,
                'unit'=>$unit,
                'absen'=>$data_absen,
                'status'=>$status,
                'jumlah'=>$jumlah,
                'min'=>$min,
                'max'=>$max,
                'avg'=>$avg,
                'sum'=>$sum,
                'min2'=>$min2,
                'max2'=>$max2,
                'avg2'=>$avg2,
                'sum2'=>$sum2,

            ];
            return view('supervisor/semua_data',$data)->with('chart_data',json_encode($data_grafik))->with('chart_data2',json_encode($data_grafik2));
        }else{
            $jumlah = 'Bulan ini';
            $tgl = date('y-m-d');
            $bulan = '0'.date('m');
            $data_pendapatan = DB::table('pendapatan')->where('id_unit',$request->id)->orderBy('tgl','desc')->get();
            $data_konsinyasi = DB::table('konsinyasi')->where('id_unit',$request->id)->orderBy('tgl','desc')->get();
            $status = DB::table('pendapatan')->where('id_unit',$request->id)->where('tgl',$tgl)->count();
            $unit = DB::table('unit')->where('id_unit',$request->id)->first();
            $data_absen = DB::table('absen_single')
                    ->join('karyawan','karyawan.id_karyawan','=','absen_single.id_karyawan')
                    ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                    ->where('karyawan.id_unit','=',$request->id)
                    ->orderBy('absen_single.tgl','asc')
                    ->get();
            $min = DB::table('pendapatan')->where('id_unit',$request->id)->whereMonth('tgl', $bulan)->min('total');
            $max = DB::table('pendapatan')->where('id_unit',$request->id)->whereMonth('tgl', $bulan)->max('total');
            $avg = DB::table('pendapatan')->where('id_unit',$request->id)->whereMonth('tgl', $bulan)->avg('total');
            $sum = DB::table('pendapatan')->where('id_unit',$request->id)->whereMonth('tgl', $bulan)->sum('total');
            $max = number_format($max,0,'','.');
            $min = number_format($min,0,'','.');
            $avg = number_format($avg,0,'','.');
            $sum = number_format($sum,0,'','.');
            $record = DB::table('pendapatan')->where('id_unit',$request->id)->whereMonth('tgl', $bulan)->orderBy('tgl','asc')->get();
            $data_grafik = [];
            foreach($record as $row){
                $data_grafik['label'][]=date('d',strtotime($row->tgl));
                $data_grafik['data'][]=$row->total;

            }
            //dd($record);

            $min2 = DB::table('konsinyasi')->where('id_unit',$request->id)->whereMonth('tgl', $bulan)->min('total');
            $max2 = DB::table('konsinyasi')->where('id_unit',$request->id)->whereMonth('tgl', $bulan)->max('total');
            $avg2 = DB::table('konsinyasi')->where('id_unit',$request->id)->whereMonth('tgl', $bulan)->avg('total');
            $sum2 = DB::table('konsinyasi')->where('id_unit',$request->id)->whereMonth('tgl', $bulan)->sum('total');
            $max2 = number_format($max2,0,'','.');
            $min2 = number_format($min2,0,'','.');
            $avg2 = number_format($avg2,0,'','.');
            $sum2 = number_format($sum2,0,'','.');
            $record2 = DB::table('konsinyasi')->where('id_unit',$request->id)->orderBy('tgl','asc')->whereMonth('tgl', $bulan)->get();
            $data_grafik2 = [];
            foreach($record2 as $row){
                $data_grafik2['label'][]=date('d',strtotime($row->tgl));
                $data_grafik2['data'][]=$row->total;

            }
            $data = [
                'pendapatan'=>$data_pendapatan,
                'konsinyasi'=>$data_konsinyasi,
                'unit'=>$unit,
                'absen'=>$data_absen,
                'status'=>$status,
                'jumlah'=>$jumlah,
                'min'=>$min,
                'max'=>$max,
                'avg'=>$avg,
                'sum'=>$sum,
                'min2'=>$min2,
                'max2'=>$max2,
                'avg2'=>$avg2,
                'sum2'=>$sum2,

            ];
            return view('supervisor/semua_data',$data)->with('chart_data',json_encode($data_grafik))->with('chart_data2',json_encode($data_grafik2));
        }
        
    }

    public function data_per_bulan(Request $request){
        $tgl = date('y-m-d');
        $bulan = '0'.$request->bulan;
        $unit = DB::table('unit')->where('id_unit',$request->unit)->first();
        
        $min = DB::table('pendapatan')->where('id_unit',$request->unit)->whereMonth('tgl', $bulan)->min('total');
        $max = DB::table('pendapatan')->where('id_unit',$request->unit)->whereMonth('tgl', $bulan)->max('total');
        $avg = DB::table('pendapatan')->where('id_unit',$request->unit)->whereMonth('tgl', $bulan)->avg('total');
        $sum = DB::table('pendapatan')->where('id_unit',$request->unit)->whereMonth('tgl', $bulan)->sum('total');
        $max = number_format($max,0,'','.');
        $min = number_format($min,0,'','.');
        $avg = number_format($avg,0,'','.');
        $sum = number_format($sum,0,'','.');
        $record = DB::table('pendapatan')->where('id_unit',$request->unit)->whereMonth('tgl', $bulan)->orderBy('tgl','asc')->get();
        $data_grafik = [];
        foreach($record as $row){
            $data_grafik['label'][]=date('d',strtotime($row->tgl));
            $data_grafik['data'][]=$row->total;

        }
        //dd($record);
        $record2 = DB::table('konsinyasi')->where('id_unit',$request->unit)->orderBy('tgl','asc')->whereMonth('tgl', $bulan)->get();
        $min2 = DB::table('konsinyasi')->where('id_unit',$request->unit)->whereMonth('tgl', $bulan)->min('total');
        $max2 = DB::table('konsinyasi')->where('id_unit',$request->unit)->whereMonth('tgl', $bulan)->max('total');
        $avg2 = DB::table('konsinyasi')->where('id_unit',$request->unit)->whereMonth('tgl', $bulan)->avg('total');
        $sum2 = DB::table('konsinyasi')->where('id_unit',$request->unit)->whereMonth('tgl', $bulan)->sum('total');
        $max2 = number_format($max2,0,'','.');
        $min2 = number_format($min2,0,'','.');
        $avg2 = number_format($avg2,0,'','.');
        $sum2 = number_format($sum2,0,'','.');
        $data_grafik2 = [];
        foreach($record2 as $row){
            $data_grafik2['label'][]=date('d',strtotime($row->tgl));
            $data_grafik2['data'][]=$row->total;

        }
        $data = [
            'pendapatan'=>$record,
            'konsinyasi'=>$record2,
            'unit'=>$unit,
            'bulan'=>$bulan,
            'tahun'=>$request->tahun,
            'min'=>$min,
            'max'=>$max,
            'avg'=>$avg,
            'sum'=>$sum,
            'min2'=>$min2,
            'max2'=>$max2,
            'avg2'=>$avg2,
            'sum2'=>$sum2

        ];
        return view('supervisor/data_per_bulan',$data)->with('chart_data',json_encode($data_grafik))->with('chart_data2',json_encode($data_grafik2));
    }
    public function cari_unit(Request $request){
        $bulan = '0'.$request->bulan;
        $data_absen = DB::table('absen_single')
                ->join('karyawan','karyawan.id_karyawan','=','absen_single.id_karyawan')
                ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                ->whereMonth('tgl', $bulan)
                ->whereYear('tgl',$request->tahun)
                ->where('karyawan.id_unit','=',$request->unit)
                ->orderBy('absen_single.tgl','asc')
                ->get();
        
        $data = [
            'data_absen'=>$data_absen,
            'unit'=>$request->unit,
            'bulan'=>$bulan,
            'tahun'=>$request->tahun
        ];
        //dd($list_tgl);
        if($data_absen->isEmpty()){
            return redirect('/cek-data')->with('status','Data yang anda cari tidak ada, Periksa Kembali')->with('alert-class','alert-danger');
        } else{
            return view('supervisor/cari-unit')->with($data);
        }
        
    }

    public function cek_karyawan(Request $request){

        //$unit = DB::table('amanah')->join('unit','unit.id_unit','=','amanah.id_unit')->orderBy('amanah.id_unit','asc')->where('id_unit')->get();
        $karyawan = DB::table('karyawan')->join('unit','unit.id_unit','=','karyawan.id_unit')
            ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')->orderBy('nama', 'asc')
            ->where('karyawan.id_unit',$request->unit)
            ->get();
        $data = [
            'data_karyawan'=>$karyawan
        ];
        return view('supervisor/cek_karyawan',$data);
    }
    
}
