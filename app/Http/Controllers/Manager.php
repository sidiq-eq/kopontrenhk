<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\karyawan;
use App\Models\konsinyasi;
use App\Models\pendapatan;
use Carbon\Carbon;

class Manager extends Controller
{
    public function __construct()
    {
        // $session = request()->session()->get('user');
        // //dd($session);
        // $tgl = date('y-m-d');
        // $bulan = date('M');
        // $data_user = DB::table('users')->where('username','=',$session)->first();
        // if ($session==null){
        //     abort(404);
        // }elseif($data_user->level!==3){
        //     abort(404);
        // }
    }
    public function index(){
        
    }
    public function beranda(){
        $session = request()->session()->get('user');
        $tgl = date('y-m-d');
        $bulan = date('M');
        $data_user = DB::table('users')->where('username','=',$session)->first();
        $user = DB::table('users')->join('unit','unit.id_unit','=','users.id_unit')->where('id',$data_user->id)->first();
        $status = DB::table('pendapatan')->where('id_unit',$data_user->id_unit)->where('tgl',$tgl)->count();
        $pendapatan = DB::table('pendapatan')->where('id_unit',$data_user->id_unit)->orderBy('tgl','asc')->latest('tgl')->limit(7)->get();
        $pendapatan_terakhir = DB::table('pendapatan')->where('id_unit',$data_user->id_unit)->latest('tgl')->first();

        $min = DB::table('pendapatan')->where('id_unit',$data_user->id_unit)->latest('tgl')->limit(7)->min('total');
        $max = DB::table('pendapatan')->where('id_unit',$data_user->id_unit)->latest('tgl')->limit(7)->max('total');
        $avg = DB::table('pendapatan')->where('id_unit',$data_user->id_unit)->latest('tgl')->limit(7)->avg('total');
        $sum = DB::table('pendapatan')->where('id_unit',$data_user->id_unit)->latest('tgl')->limit(7)->sum('total');
        $max = number_format($max,0,'','.');
        $min = number_format($min,0,'','.');
        $avg = number_format($avg,0,'','.');
        $sum = number_format($sum,0,'','.');
        //$pendapatan_selisih = DB::table('pendapatan')->where('id_unit',$data_user->id_unit)->latest('tgl')->limit(2)->get();
        //dd($pendapatan_selisih);
        if($pendapatan_terakhir==null){

            $pendapatan_terakhir='';
        }else{
            $pendapatan_terakhir;
        }
        $tanggal = DB::table('pendapatan')->select('tgl')->where('id_unit',$data_user->id_unit)->limit(7)->get();
        // $date = [];
        // foreach($tanggal as $key =>$value){
        //     $date[] = DB::table('pendapatan')->select('tgl')->where('id_unit',$data_user->id_unit)->limit(7)->count();
        // }
        // $data_pendapatan = [];
        // foreach($tanggal as $key =>$value){
        //    $data_pendapatan[] = DB::table('pendapatan')->select('total')->where('id_unit',$data_user->id_unit)->limit(7)->count();
        // }
        $record = DB::table('pendapatan')->where('id_unit',$data_user->id_unit)->latest('tgl')->limit(7)->get();
        $record = $record->reverse();
        $data_grafik = [];
        foreach($record as $row){
            $data_grafik['label'][]=date('d/m',strtotime($row->tgl));
            $data_grafik['data'][]=$row->total;

        }

        //$total = DB::table('pendapatan')->select('total')->where('id_unit',$data_user->id_unit)->limit(7)->get();
        $data = [
            'user'=>$user,
            'status'=>$status,
            'pendapatan'=>$pendapatan,
            'pendapatan_terakhir'=>$pendapatan_terakhir,
            'min'=>$min,
            'max'=>$max,
            'avg'=>$avg,
            'sum'=>$sum,
            // 'total'=>$total,
            // 'tgl'=>$tgl
        ];
        return view('manager/beranda3',$data)->with('chart_data',json_encode($data_grafik));
    }
    public function form_pendapatan(){
        $session = request()->session()->get('user');
        $data_user = DB::table('users')->where('username','=',$session)->first();
        $unit = DB::table('users')->join('unit','unit.id_unit','=','users.id_unit')->where('id',$data_user->id)->get();
        //dd($unit);
        $data = [
            'unit'=>$unit,
        ];
        return view('manager/form',$data);
    }

    public function form_konsinyasi(){
        $session = request()->session()->get('user');
        $data_user = DB::table('users')->where('username','=',$session)->first();
        $unit = DB::table('users')->join('unit','unit.id_unit','=','users.id_unit')->where('id',$data_user->id)->get();
        //dd($unit);
        $data = [
            'unit'=>$unit,
        ];
        return view('manager/form_konsinyasi',$data);
    }
    public function tambah_pendapatan(Request $request){
        $tgl = date("Y-m-d", strtotime($request->tgl));
        $cek_pendapatan = DB::table('pendapatan')->where('tgl',$tgl)->where('id_unit',$request->unit)->count();
        if($cek_pendapatan>0){
            return redirect('detail-pendapatan')->with('status','Gagal! Anda telah submit laporan di tanggal yang sama')->with('alert-class','alert-danger');
        
        }else{
            $pendapatan = new pendapatan;
            $pdn = preg_replace('/\./', '', $request->pendapatan); 
            $ksbn = preg_replace('/\./', '', $request->kasbon); 
            $pendapatan->tgl = $request->tgl;
            $pendapatan->id_unit = $request->unit;
            $pendapatan->pendapatan = $pdn;
            $pendapatan->kasbon = $ksbn;
            $pendapatan->total = $request->total;
            if($pendapatan->save()){
                return redirect('detail-pendapatan')->with('status','Data Pendapatan Telah Masuk')->with('alert-class','alert-success');
            } else{
                return redirect('detail-pendapatan')->with('status','Data Gagal masuk')->with('alert-class','alert-danger');
            }
        }

        
    }
    public function tambah_konsinyasi(Request $request){
        $tgl = date("Y-m-d", strtotime($request->tgl));
        $cek_konsinyasi = DB::table('konsinyasi')->where('tgl',$tgl)->where('id_unit',$request->unit)->count();
        if($cek_konsinyasi>0){
            return redirect('detail-pendapatan')->with('status','Gagal! Anda telah submit laporan di tanggal yang sama')->with('alert-class','alert-danger');
        
        }else{
            $konsinyasi = new konsinyasi;
            $total = preg_replace('/\./', '', $request->total); 
            $konsinyasi->tgl = $request->tgl;
            $konsinyasi->id_unit = $request->unit;
            $konsinyasi->total = $total;
            if($konsinyasi->save()){
                return redirect('detail-pendapatan')->with('status','Data Konsinyasi Telah Masuk')->with('alert-class','alert-success');
            } else{
                return redirect('detail-pendapatan')->with('status','Data Gagal masuk')->with('alert-class','alert-danger');
            }
        }

        
    }
    public function karyawan(){
        $session = request()->session()->get('user');
        $data_user = DB::table('users')->where('username','=',$session)->first();
        $user = DB::table('users')->join('unit','unit.id_unit','=','users.id_unit')->where('id',$data_user->id)->first();
        //dd($user);
        $amanah = DB::table('amanah')->join('unit','unit.id_unit','=','amanah.id_unit')->orderBy('amanah.id_unit','asc')->where('amanah.id_unit',$user->id_unit)->get();
        $karyawan = DB::table('karyawan')->join('unit','unit.id_unit','=','karyawan.id_unit')->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')->where('karyawan.id_unit',$user->id_unit)->orderBy('nama', 'asc')->get();
        $data = [
            'user'=>$user,
            'data_unit'=>$amanah,
            'data_karyawan'=>$karyawan
        ];
        return view('manager/karyawan',$data);
    }

    public function tambah_karyawan(Request $request){
        $karyawan = new karyawan;
        $karyawan->nama = $request->nama;
        $karyawan->id_unit = $request->id_unit;
        $karyawan->id_amanah = $request->id_amanah;
        $karyawan->masuk = $request->tgl;
        $karyawan->no_hp = $request->no_hp;
        if($karyawan->save()){
            return redirect('karyawan-manager')->with('status','Data Karyawan Telah Masuk')->with('alert-class','alert-success');
        } else{
            return redirect('karyawan-manager')->with('status','Data Gagal masuk')->with('alert-class','alert-danger');
        }
    }
    public function update_karyawan(Request $request){
        $karyawan = new karyawan;
        
        $data = [
            'id_karyawan'=>$request->id_karyawan,
            'nama'=>$request->nama_edit,
            'id_unit'=>$request->id_unit_edit,
            'id_amanah'=>$request->id_amanah_edit,
            'masuk'=>$request->tgl_edit,
            'no_hp'=>$request->no_hp_edit
        ];
        //$value = DB::update('update users set nama = $data['nama'], where name = ?', $karyawan->id_karyawan);
        $hasil = DB::table('karyawan')->where('id_karyawan',$data['id_karyawan'])->update([
            'nama'=>$data['nama'],
            'id_unit'=>$data['id_unit'],
            'id_amanah'=>$data['id_amanah'],
            'masuk'=>$data['masuk'],
            'no_hp'=>$data['no_hp']
        ]);
        if($hasil=true){
            return redirect('karyawan-manager')->with('status','Data Karyawan Telah di ubah')->with('alert-class','alert-success');
        } else{
            return redirect('karyawan-manager')->with('status','Data Gagal masuk')->with('alert-class','alert-danger');
        }
    }
    public function hapus_karyawan(Request $request){
        $hasil = DB::table('karyawan')->where('id_karyawan', '=', $request->id_hapus)->delete();
        if($hasil=true){
            return redirect('karyawan-manager')->with('status','atas nama '.$request->nama_hapus.' Telah di hapus')->with('alert-class','alert-success');
        } else{
            return redirect('karyawan-manager')->with('status','Data Gagal di hapus')->with('alert-class','alert-danger');
        }
    }
    public function detail_pendapatan(){
        $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $valuebulan = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        $tahun = ['2021','2022','2023','2024','2025','2026','2027'];
        $session = request()->session()->get('user');
        $data_user = DB::table('users')->where('username','=',$session)->first();
        $user = DB::table('users')->join('unit','unit.id_unit','=','users.id_unit')->where('id',$data_user->id)->first();
        $data_pendapatan = DB::table('pendapatan')->where('id_unit',$data_user->id_unit)->orderBy('tgl','desc')->get();
        $data_konsinyasi = DB::table('konsinyasi')->where('id_unit',$data_user->id_unit)->orderBy('tgl','desc')->get();


        $record = DB::table('pendapatan')->where('id_unit',$data_user->id_unit)->latest('tgl')->limit(14)->get();
        $record = $record->reverse();
        $data_grafik = [];
        foreach($record as $row){
            $data_grafik['label'][]=date('d/m',strtotime($row->tgl));
            $data_grafik['data'][]=$row->total;

        }

        $record2 = DB::table('konsinyasi')->where('id_unit',$data_user->id_unit)->latest('tgl')->limit(14)->get();
        $record2 = $record2->reverse();
        $data_grafik2 = [];
        foreach($record2 as $row){
            $data_grafik2['label'][]=date('d/m',strtotime($row->tgl));
            $data_grafik2['data'][]=$row->total;

        }
        $data = [
            'user'=>$user,
            'pendapatan'=>$data_pendapatan,
            'konsinyasi'=>$data_konsinyasi,
            'bulan'=>$bulan,
            'tahun'=>$tahun,
        ];
        return view('manager/pendapatan',$data)->with('chart_data',json_encode($data_grafik))->with('chart_data2',json_encode($data_grafik2));
    }
    public function buat_pendapatan(Request $request){
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
        return view('manager/buat-laporan',$data)->with('chart_data',json_encode($data_grafik))->with('chart_data2',json_encode($data_grafik2));
    }
    public function rekap_absen(){
        $session = request()->session()->get('user');
        $data_user = DB::table('users')->where('username','=',$session)->first();
        $user = DB::table('users')->join('unit','unit.id_unit','=','users.id_unit')->where('id',$data_user->id)->first();
        $date = date('y-m-d');
        $cek_absen = DB::table('absen')
                    ->join('karyawan','karyawan.id_karyawan','=','absen.id_karyawan')
                    ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                    ->where('karyawan.id_unit',$user->id_unit)
                    ->orderBy('absen.waktu','desc')->where('absen.tgl','=', $date)->get();
        
        $karyawan = DB::table('karyawan')->orderBy('nama', 'asc')->where('id_unit',$user->id_unit)->get();
        $unit = DB::table('unit')->join('amanah','amanah.id_unit','=','unit.id_unit')->orderBy('unit.id_unit','asc')->groupBy('unit.id_unit')->get();
        $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $valuebulan = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        $tahun = ['2021','2022','2023','2024','2025','2026','2027'];
        $data=[
            'karyawan'=>$karyawan,
            'bulan'=>$bulan,
            'tahun'=>$tahun,
            'unit'=>$unit,
            'valuebulan'=>$valuebulan,
            'listabsen'=>$cek_absen
        ];
        return view('manager/rekap_absen',$data);
    }
    public function cari_nama(Request $request){
        $bulan = '0'.$request->bulan;
        $data_absen = DB::table('absen_single')
                ->join('karyawan','karyawan.id_karyawan','=','absen_single.id_karyawan')
                ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                ->whereMonth('tgl', $bulan)
                ->whereYear('tgl',$request->tahun)
                ->where('absen_single.id_karyawan','=',$request->nama)
                ->orderBy('absen_single.tgl','asc')
                ->get();
        $nama = DB::table('karyawan')->select('karyawan.nama')->where('karyawan.id_karyawan','=',$request->nama)->pluck('nama');
        
        $data = [
            'data_absen'=>$data_absen,
            'id'=>$request->nama,
            'nama'=>$nama,
            'bulan'=>$bulan,
            'tahun'=>$request->tahun
        ];
        if($data_absen->isEmpty()){
            return redirect('/rekap-absen')->with('status','Data yang anda cari tidak ada, Periksa Kembali')->with('alert-class','alert-danger');
        } else{
            return view('manager/cari-nama')->with($data);
        }
        
    }
    public function cari_bulan(Request $request){
        $bulan = '0'.$request->bulan;
        $data_absen = DB::table('absen_single')
                ->join('karyawan','karyawan.id_karyawan','=','absen.id_karyawan')
                ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                ->whereMonth('tgl', $bulan)
                ->whereYear('tgl',$request->tahun)
                ->where('id_unit')
                ->orderBy('karyawan.nama','asc')
                ->get();
        if($data_absen->isEmpty()){
            return redirect('/rekap-absen')->with('status','Data yang anda cari tidak ada, Periksa Kembali')->with('alert-class','alert-danger');
        } else{
            return view('manager/cari-bulan')->with('data_absen',$data_absen);
        }
        
    }
    public function cari_tanggal(Request $request){
        $session = request()->session()->get('user');
        $data_user = DB::table('users')->where('username','=',$session)->first();
        $user = DB::table('users')->join('unit','unit.id_unit','=','users.id_unit')->where('id',$data_user->id)->first();
        
        $bulan = '0'.$request->bulan;
        $data_absen = DB::table('absen_single')
                ->join('karyawan','karyawan.id_karyawan','=','absen_single.id_karyawan')
                ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                ->whereDay('tgl', $request->tgl)
                ->whereMonth('tgl', $bulan)
                ->whereYear('tgl',$request->tahun)
                ->where('karyawan.id_unit',$user->id_unit)
                ->orderBy('karyawan.nama','asc')
                ->get();
        
        $data = [
            'data_absen'=>$data_absen,
            'tgl'=>$request->tgl,
            'bulan'=>$bulan,
            'tahun'=>$request->tahun
        ];
        //dd($list_tgl);
        if($data_absen->isEmpty()){
            return redirect('/rekap-absen')->with('status','Data yang anda cari tidak ada, Periksa Kembali')->with('alert-class','alert-danger');
        } else{
            return view('manager/cari-tanggal')->with($data);
        }
        
    }
}
