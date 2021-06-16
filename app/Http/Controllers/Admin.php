<?php

namespace App\Http\Controllers;
use App\Models\Unit;
use App\Models\amanah;
use App\Models\karyawan;
use App\Models\User;
use Dotenv\Parser\Value;
use Illuminate\Http\Request;
use App\Http\Controllers\Redirect;
use Illuminate\Support\Facades\DB;

class Admin extends Controller
{
    public function login(){
        $data['title'] = 'Login System';
        return view('login',$data);
    }
    public function auth(Request $request){
        $user = DB::table('users')->get();
        $username = $request->username;
        $password = $request->password;
        $request->session()->put('user',$username);
        echo session('user');
        if($username == 'admin' && $password == 'admin2021'){
            return redirect('karyawan');
        } else{
            return redirect('login')->with('status','Username & password salah');
        }


    }
    public function beranda(){
        return view('admin/beranda');
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
            return redirect('karyawan')->with('status','Data Karyawan Telah Masuk');
        } else{
            return redirect('karyawan')->with('status','Data Gagal masuk');
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
            return redirect('karyawan')->with('status','Data Karyawan Telah di ubah');
        } else{
            return redirect('karyawan')->with('status','Data Gagal masuk');
        }
    }
    public function hapus_karyawan(Request $request){
        $hasil = DB::table('karyawan')->where('id_karyawan', '=', $request->id_hapus)->delete();
        if($hasil=true){
            return redirect('karyawan')->with('status','atas nama '.$request->nama_hapus.' Telah di hapus');
        } else{
            return redirect('karyawan')->with('status','Data Gagal di hapus');
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
        if($admin->save()){
            return redirect('unit')->with('status','Data Telah Masuk');
        } else{
            return redirect('unit')->with('status','Data Gagal masuk');
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
            return redirect('unit')->with('status','Data Unit Telah di ubah');
        } else{
            return redirect('unit')->with('status','Data Gagal masuk');
        }
    }
    public function hapus_unit(Request $request){
        $hasil = DB::table('unit')->where('id_unit', '=', $request->id)->delete();
        if($hasil=true){
            return redirect('unit')->with('status','Data berhasil di hapus');
        } else{
            return redirect('unit')->with('status','Data Gagal');
        }
    }
    public function tambah_amanah(Request $request){
        $admin = new amanah;
        $admin->nama_amanah = $request->nama;
        $admin->id_unit = $request->kode;
        if($admin->save()){
            return redirect('unit')->with('status','Data Telah Masuk');
        } else{
            return redirect('unit')->with('status','Data Gagal masuk');
        }
    }
    public function hapus_amanah(Request $request){
        $hasil = DB::table('amanah')->where('id_amanah', '=', $request->id)->delete();
        if($hasil=true){
            return redirect('unit')->with('status','Data berhasil di hapus');
        } else{
            return redirect('unit')->with('status','Data Gagal');
        }
    }
    public function list_absen(){
        $date = date('y-m-d');
        $cek_absen = DB::table('absen')
                    ->join('karyawan','karyawan.id_karyawan','=','absen.id_karyawan')
                    ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                    ->orderBy('absen.waktu','desc')->where('absen.tgl','=', $date)->get();
        
        $karyawan = DB::table('karyawan')->orderBy('nama', 'asc')->get();
        $unit = DB::table('amanah')->join('unit','unit.id_unit','=','amanah.id_unit')->orderBy('amanah.id_unit','asc')->get();
        $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $valuebulan = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        $tahun = ['2021','2022','2023','2024'];
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
        $data_absen = DB::table('absen')
                ->join('karyawan','karyawan.id_karyawan','=','absen.id_karyawan')
                ->whereMonth('tgl', $bulan)
                ->whereYear('tgl',$request->tahun)
                ->where('absen.id_karyawan','=',$request->nama)
                ->orderBy('absen.tgl','desc')
                ->get();
        
        if($data_absen->isEmpty()){
            return redirect('/list_absen')->with('status','Data yang anda cari tidak ada, Periksa Kembali');
        } else{
            return view('admin/cari-nama')->with('data_absen',$data_absen);
        }
        
    }
    public function cari_unit(Request $request){
        $bulan = '0'.$request->bulan;
        $data_absen = DB::table('absen')
                ->join('karyawan','karyawan.id_karyawan','=','absen.id_karyawan')
                ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                ->whereMonth('tgl', $bulan)
                ->whereYear('tgl',$request->tahun)
                ->where('karyawan.id_unit','=',$request->unit)
                ->orderBy('absen.tgl','asc')
                ->get();
        if($data_absen->isEmpty()){
            return redirect('/list_absen')->with('status','Data yang anda cari tidak ada, Periksa Kembali');
        } else{
            return view('admin/cari-unit')->with('data_absen',$data_absen);
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
            return redirect('/list_absen')->with('status','Data yang anda cari tidak ada, Periksa Kembali');
        } else{
            return view('admin/cari-bulan')->with('data_absen',$data_absen);
        }
        
    }
    public function cari_tanggal(Request $request){
        dd($request);
        $bulan = '0'.$request->bulan;
        $data_absen = DB::table('absen')
                ->join('karyawan','karyawan.id_karyawan','=','absen.id_karyawan')
                ->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')
                ->whereDate('tgl', $request->tgl)
                ->whereMonth('tgl', $bulan)
                ->whereYear('tgl',$request->tahun)
                ->orderBy('karyawan.nama','asc')
                ->get();
        if($data_absen->isEmpty()){
            return redirect('/list_absen')->with('status','Data yang anda cari tidak ada, Periksa Kembali');
        } else{
            return view('admin/cari-bulan')->with('data_absen',$data_absen);
        }
        
    }
}
