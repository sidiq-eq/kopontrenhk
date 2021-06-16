<?php

namespace App\Http\Controllers;
use Symfony\Component\Console\Input\Input;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\absen_model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Absen extends BaseController
{
    //
    protected $model = absen_model::class;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function home()
    {
        $karyawan = DB::table('karyawan')->join('unit','unit.id_unit','=','karyawan.id_unit')->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')->orderBy('nama', 'asc')->get();
        return view('index',['data'=>$karyawan]);
    }
    public function cek(){
        $date = date('y-m-d');
        $tgl = DB::table('absen')->where('tgl','=',$date)->get();
        $cek_absen = DB::table('absen')->join('karyawan','karyawan.id_karyawan','=','absen.id_karyawan')->join('amanah','amanah.id_amanah','=','karyawan.id_amanah')->orderBy('absen.waktu','desc')->where('absen.tgl','=', $date)->get();
        $data = [
            'data_absen'=>$cek_absen,
            'tgl'=>$tgl
        ];
        //dd($cek_absen);
        return view('cek',$data);
    }
    public function info(){
        return view('info');
    }
    public function submit(Request $request){
        $fileName = '';
            try {
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->foto));
                $fileName = uniqid().'.jpg';
                file_put_contents('asset/images/'.$fileName, $data);
            }
            catch (\Exception $e) {
                $msg = $e;
            }
        
        $validated = $request->validate([
            'nama' => 'required',
            'foto'=> 'required',
            'lokasi'=> 'required'
        ]);
        $tgl = date('Y-d-m',strtotime($request->tgl));
        $absen_model = new absen_model;
        $absen_model->id_karyawan = $request->id;
        $absen_model->tgl = $tgl;
        $absen_model->waktu = $request->waktu;
        $absen_model->ket = $request->ket;
        $absen_model->lokasi = $request->lokasi;
        $absen_model->foto = $fileName;
        $cek_absen = DB::table('absen')->orderBy('absen.waktu','desc')->where([
            ['absen.id_karyawan','=',$request->id],
            ['absen.ket','=',$request->ket],
            ['absen.tgl','=',$tgl]
        ])->count();
        if($cek_absen > 0){
            return redirect('cek')->with('status','Data Tidak Masuk, '.$request->nama.' Anda telah absen sebelumnya dengan status sama!');
        }else{
            if($absen_model->save()){
                return redirect('cek')->with('status','Alhamdulillah, '.$request->nama.' Anda telah absen '.$request->ket.'');
            } else{
                return redirect('cek')->with('status','Data Gagal masuk');
            }
        }
        
    }
}
