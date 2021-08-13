<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\amanah;
use App\Models\karyawan;
use App\Models\AbsenSingle;
use App\Models\User;
use Dotenv\Parser\Value;
use Illuminate\Http\Request;
use App\Http\Controllers\Redirect;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Exports\ExportUnit;
use App\Exports\ExportNama;
use App\Exports\ExportTanggal;
use Illuminate\Support\Facades\Auth;

class Admin extends Controller
{
    public function __construct()
    {
    //
        
        // $session = request()->session()->get('user');
        // //dd($session);
        // $tgl = date('y-m-d');
        // $bulan = date('M');
        // $data_user = DB::table('users')->where('username','=',$session)->first();
        // if ($session==null){
        //     abort(404);
        // }elseif($data_user->id !==1){
        //     abort(404);
        // }
    }
    public function index(){
        $user = Auth::user();
        return view('admin/beranda', compact('user'));
    }
    public function beranda(){
        $date = date('y-m-d');
        $session = request()->session()->get('user');
        $data_user = DB::table('users')->where('username','=',$session)->first();
        $user = DB::table('users')->join('unit','unit.id_unit','=','users.id_unit')->where('id',$data_user->id)->first();
        $unit = DB::table('unit')->where('status','Terdaftar')->get();
        $cek_absen = DB::table('absen')
                    ->join('karyawan','karyawan.id_karyawan','=','absen.id_karyawan')
                    ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                    ->orderBy('absen.waktu','desc')->where('absen.tgl','=', $date)->limit(5)->get();
        $data_pendapatan = DB::table('pendapatan')->orderBy('tgl','desc')->limit(5)->get();
        $data_konsinyasi = DB::table('konsinyasi')->orderBy('tgl','desc')->limit(5)->get();
        $data = [
            'unit'=>$unit,
            'user'=>$user,
            'absen'=>$cek_absen,
            'pendapatan'=>$data_pendapatan,
            'konsinyasi'=>$data_konsinyasi
        ];
        return view('admin/beranda',$data);
        
    }
    public function karyawan(){
        $unit = DB::table('amanah')->join('unit','unit.id_unit','=','amanah.id_unit')->orderBy('amanah.id_unit','asc')->get();
        $karyawan = DB::table('karyawan')->join('unit','unit.id_unit','=','karyawan.id_unit')->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')->orderBy('nama', 'asc')->get();
        $data = [
            'data_unit'=>$unit,
            'data_karyawan'=>$karyawan
        ];
        return view('admin/karyawan',$data);
    }
    public function tambah_karyawan(Request $request){
        $karyawan = new karyawan;
        $karyawan->nama = $request->nama;
        $karyawan->id_unit = $request->id_unit;
        $karyawan->id_amanah = $request->id_amanah;
        $karyawan->masuk = $request->tgl;
        $karyawan->no_hp = $request->no_hp;
        if($karyawan->save()){
            return redirect('karyawan')->with('status','Data Karyawan Telah Masuk')->with('alert-class','alert-success');
        } else{
            return redirect('karyawan')->with('status','Data Gagal masuk')->with('alert-class','alert-danger');
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
            return redirect('karyawan')->with('status','Data Karyawan Telah di ubah')->with('alert-class','alert-success');
        } else{
            return redirect('karyawan')->with('status','Data Gagal masuk')->with('alert-class','alert-danger');
        }
    }
    public function hapus_karyawan(Request $request){
        $hasil = DB::table('karyawan')->where('id_karyawan', '=', $request->id_hapus)->delete();
        if($hasil=true){
            return redirect('karyawan')->with('status','atas nama '.$request->nama_hapus.' Telah di hapus')->with('alert-class','alert-success');
        } else{
            return redirect('karyawan')->with('status','Data Gagal di hapus')->with('alert-class','alert-danger');
        }
    }
    public function unit(){
        $amanah = DB::table('amanah')->join('unit','unit.id_unit','=','amanah.id_unit')->orderBy('unit.id_unit', 'asc')->get();
        $unit = DB::table('unit')->orderBy('nama_unit', 'asc')->get();
        $data =[
            'data2'=> $amanah,
            'data'=>$unit
        ];
        return view('admin/unit', $data);
    }
    public function amanah(){
    }
    public function tambah_unit(Request $request){
        $admin = new Unit;
        $admin->id_unit = $request->id;
        $admin->nama_unit = $request->nama;
        $admin->status = 'Tidak Terdaftar';
        if($admin->save()){
            return redirect('unit')->with('status','Data Telah Masuk')->with('alert-class','alert-success');
        } else{
            return redirect('unit')->with('status','Data Gagal masuk')->with('alert-class','alert-danger');
        }
    }
    public function update_unit(Request $request){
        $admin = new Unit;
        $data = [
            'id_unit'=>$request->id,
            'nama_unit'=>$request->nama,
        ];
        //$value = DB::update('update users set nama = $data['nama'], where name = ?', $karyawan->id_karyawan);
        $hasil = DB::table('unit')->where('id_unit',$data['id_unit'])->update([
            'nama_unit'=>$data['nama_unit'],
        ]);
        if($hasil=true){
            return redirect('unit')->with('status','Data Unit Telah di ubah')->with('alert-class','alert-success');
        } else{
            return redirect('unit')->with('status','Data Gagal masuk')->with('alert-class','alert-danger');
        }
    }
    public function daftarkan_unit(Request $request){
        $data = [
            'id_unit'=>$request->id,
            'status'=>'Terdaftar',
        ];
        //$value = DB::update('update users set nama = $data['nama'], where name = ?', $karyawan->id_karyawan);
        $hasil = DB::table('unit')->where('id_unit',$data['id_unit'])->update([
            'status'=>$data['status'],
        ]);
        if($hasil=true){
            return redirect('unit')->with('status',$data['id_unit'].' Telah di Daftarkan')->with('alert-class','alert-success');
        } else{
            return redirect('unit')->with('status','Data Gagal masuk')->with('alert-class','alert-danger');
        }
    }
    public function hapusdaftarkan_unit(Request $request){
        
        $data = [
            'id_unit'=>$request->id,
            'status'=>'	Tidak didaftarkan',
        ];
        //$value = DB::update('update users set nama = $data['nama'], where name = ?', $karyawan->id_karyawan);
        $hasil = DB::table('unit')->where('id_unit',$data['id_unit'])->update([
            'status'=>$data['status'],
        ]);
        if($hasil=true){
            return redirect('unit')->with('status',$data['id_unit'].' Telah hapus dari daftar')->with('alert-class','alert-danger');
        } else{
            return redirect('unit')->with('status','Data Gagal masuk')->with('alert-class','alert-danger');
        }
    }
    public function hapus_unit(Request $request){
        $hasil = DB::table('unit')->where('id_unit', '=', $request->id)->delete();
        if($hasil=true){
            return redirect('unit')->with('status','Data berhasil di hapus')->with('alert-class','alert-success');
        } else{
            return redirect('unit')->with('status','Data Gagal')->with('alert-class','alert-danger');
        }
    }
    public function tambah_amanah(Request $request){
        $admin = new amanah;
        $admin->nama_amanah = $request->nama;
        $admin->id_unit = $request->kode;
        if($admin->save()){
            return redirect('unit')->with('status','Data Telah Masuk')->with('alert-class','alert-success');
        } else{
            return redirect('unit')->with('status','Data Gagal masuk')->with('alert-class','alert-danger');
        }
    }
    public function hapus_amanah(Request $request){
        $hasil = DB::table('amanah')->where('id_amanah', '=', $request->id)->delete();
        if($hasil=true){
            return redirect('unit')->with('status','Data berhasil di hapus')->with('alert-class','alert-success');
        } else{
            return redirect('unit')->with('status','Data Gagal')->with('alert-class','alert-danger');
        }
    }

    public function laporan_pendapatan(){
        $unit_terdaftar = DB::table('unit')->join('amanah','amanah.id_unit','=','unit.id_unit')->where('status','Terdaftar')->orderBy('unit.id_unit','asc')->groupBy('unit.id_unit')->get();
        $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $valuebulan = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        $tahun = ['2021','2022','2023','2024','2025','2026','2027'];

        $data = [
            'bulan'=>$bulan,
            'valuebulan'=>$valuebulan,
            'tahun'=>$tahun,
            'terdaftar'=>$unit_terdaftar
        ];
        return view('admin/laporan-pendapatan',$data);
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
        return view('admin/buat-laporan',$data)->with('chart_data',json_encode($data_grafik))->with('chart_data2',json_encode($data_grafik2));
    }

    public function list_absen(){
        $date = date('y-m-d');
        $cek_absen = DB::table('absen')
                    ->join('karyawan','karyawan.id_karyawan','=','absen.id_karyawan')
                    ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                    ->orderBy('absen.waktu','desc')->where('absen.tgl','=', $date)->get();
        
        $karyawan = DB::table('karyawan')->orderBy('nama', 'asc')->get();
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
        return view('admin/list_absen',$data);
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
            return redirect('/list_absen')->with('status','Data yang anda cari tidak ada, Periksa Kembali')->with('alert-class','alert-danger');
        } else{
            return view('admin/cari-nama')->with($data);
        }
        
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
            return redirect('/list_absen')->with('status','Data yang anda cari tidak ada, Periksa Kembali')->with('alert-class','alert-danger');
        } else{
            return view('admin/cari-unit')->with($data);
        }
        
    }
    public function cari_bulan(Request $request){
        $bulan = '0'.$request->bulan;
        $data_absen = DB::table('absen')
                ->join('karyawan','karyawan.id_karyawan','=','absen.id_karyawan')
                ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                ->whereMonth('tgl', $bulan)
                ->whereYear('tgl',$request->tahun)
                ->orderBy('karyawan.nama','asc')
                ->get();
        if($data_absen->isEmpty()){
            return redirect('/list_absen')->with('status','Data yang anda cari tidak ada, Periksa Kembali')->with('alert-class','alert-danger');
        } else{
            return view('admin/cari-bulan')->with('data_absen',$data_absen);
        }
        
    }
    public function cari_tanggal(Request $request){
        //dd($request);
        $bulan = '0'.$request->bulan;
        $data_absen = DB::table('absen_single')
                ->join('karyawan','karyawan.id_karyawan','=','absen_single.id_karyawan')
                ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                ->whereDay('tgl', $request->tgl)
                ->whereMonth('tgl', $bulan)
                ->whereYear('tgl',$request->tahun)
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
            return redirect('/list_absen')->with('status','Data yang anda cari tidak ada, Periksa Kembali')->with('alert-class','alert-danger');
        } else{
            return view('admin/cari-tanggal')->with($data);
        }
        
    }

    public function get_detail(Request $request){
        $id = $request->input('id');
        $tgl = $request->input('tgl');
        //dd($tgl);
        $data_absen = DB::table('absen')
                ->join('karyawan','karyawan.id_karyawan','=','absen.id_karyawan')
                ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                ->where('absen.id_karyawan',$id)
                ->where('absen.tgl',$tgl)
                ->orderBy('karyawan.nama','asc')
                ->get();
                //dd($data_absen);

        return response()->json($data_absen, 200);
        //echo json_encode($data_absen);
    }

    public function komponen(){
        $unit = DB::table('amanah')->join('unit','unit.id_unit','=','amanah.id_unit')->orderBy('amanah.id_unit','asc')->get();
        $karyawan = DB::table('karyawan')->join('unit','unit.id_unit','=','karyawan.id_unit')->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')->orderBy('nama', 'asc')->get();
        $data = [
            'data_unit'=>$unit,
            'data_karyawan'=>$karyawan
        ];
        return view('admin/komponen',$data);
    }
    public function user(){
        $unit = DB::table('unit')->where('status','Terdaftar')->orderBy('nama_unit', 'asc')->get();
        $user = DB::table('users')->get();
        $karyawan = DB::table('karyawan')->join('unit','unit.id_unit','=','karyawan.id_unit')->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')->orderBy('nama', 'asc')->get();
        $data = [
            'data_unit'=>$unit,
            'data_karyawan'=>$karyawan,
            'user'=>$user
        ];
        return view('admin/user',$data);
    }
    public function tambah_user(Request $request){
        $admin = new User;
        $admin->name = $request->nama;
        $admin->username = $request->username;
        $admin->password = $request->password;
        $admin->level = $request->level;
        $admin->id_karyawan = $request->karyawan;
        $admin->id_unit = $request->unit;
        if($admin->save()){
            return redirect('user')->with('status', 'User '.$request->nama.' Telah Masuk')->with('alert-class','alert-success');
        } else{
            return redirect('user')->with('status','Data Gagal masuk')->with('alert-class','alert-danger');
        }
    }

    public function export_unit(Request $request){
        $unit = $request->unit;
        $bulan = '0'.$request->bulan;
        $tahun = $request->tahun;
        return Excel::download(new ExportUnit($unit,$bulan,$tahun),'unit_'.$unit.date('Y-m-d_H-i-s').'.xlsx');
    }
    public function export_nama(Request $request){
        $nama = $request->nama;
        $bulan = '0'.$request->bulan;
        $tahun = $request->tahun;
        return Excel::download(new ExportNama($nama,$bulan,$tahun),'nama_'.$nama.date('Y-m-d_H-i-s').'.xlsx');
    }
    public function export_tanggal(Request $request){
        $tgl = $request->tgl;
        $bulan = '0'.$request->bulan;
        $tahun = $request->tahun;
        return Excel::download(new ExportTanggal($tgl,$bulan,$tahun),'tgl'.date('Y-m-d_H-i-s').'.xlsx');
    }
}
