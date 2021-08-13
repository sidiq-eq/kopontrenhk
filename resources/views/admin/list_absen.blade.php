@extends('layout/mainadmin')

@section('title','Cek Absensi')
@section('main')
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Data Absen</h1>
        <div class="row">
            <div class="container" >
                @if (session('status'))
                            <div class="alert {{session('alert-class')}} alert-dismissible" role="alert" id="message">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <div class="alert-message" >
                                    <b>{{session('status')}}</b>
                                </div>
                            </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Cari Data Absen</h5>
                        <h6 class="card-subtitle text-muted">Berdasarkan Nama Karyawan, Bulan & Tahun</h6>
                    </div>
                    <div class="card-body text-center">
                        <form action="/cari-nama" method="post">
                            @csrf
                            <div class="row">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="">Nama</label>
                                    <select class="form-select" id="" name="nama">
                                    <option selected disabled>-- Pilih Nama Karyawan --</option>
                                    @foreach ($karyawan as $data)
                                    <option value="{{$data->id_karyawan}}">{{$data->nama}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                        <div class="row">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="">Bulan</label>
                                <select class="form-select" id="" name="bulan">
                                    <?php 
                                    $i =1;
                                    $date = date('m');
                                    ?>
                                    @foreach ($bulan as $data)
                                        @if ($date == $i)
                                        <option value="{{$i++}}" selected>{{$data}}</option>
                                        
                                        
                                        @else
                                        <option value="{{$i++}}">{{$data}}</option>
                                            
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="">Tahun</label>
                                <select class="form-select" id="" name="tahun">
                                    @foreach ($tahun as $data)
                                    @if ($data=='2021')
                                        <option value="{{$data}}" selected>{{$data}}</option>
                                        @else
                                        <option value="{{$data}}">{{$data}}</option>  
                                        @endif
                                        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-info"><li class="fas fa-search"></li> Cari Data</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Cari Data Absen</h5>
                        <h6 class="card-subtitle text-muted">Berdasarkan Nama Unit, Bulan & Tahun</h6>
                    </div>
                    <div class="card-body text-center">
                        <form action="/cari-unit" method="post">
                            @csrf
                            <div class="row">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="">Unit</label>
                                    <select class="form-select" name="unit" id="">
                                        <option selected disabled>-- Pilih Unit --</option>
                                        @foreach ($unit as $data)
                                    <option value="{{$data->id_unit}}">{{$data->nama_unit}}</option>
                                    @endforeach
                                    
                                </select>
                                </div>
                            </div>
                        <div class="row">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="">Bulan</label>
                                <select class="form-select" id="" name="bulan">
                                    <?php 
                                    $i =1;
                                    $date = date('m');
                                    ?>
                                    @foreach ($bulan as $data)
                                    @if ($date == $i)
                                    <option value="{{$i++}}" selected>{{$data}}</option>
                                        
                                    
                                    @else
                                    <option value="{{$i++}}">{{$data}}</option>
                                    
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="">Tahun</label>
                                <select class="form-select" id="" name="tahun">
                                    @foreach ($tahun as $data)
                                        @if ($data=='2021')
                                        <option value="{{$data}}" selected>{{$data}}</option>
                                        @else
                                        <option value="{{$data}}">{{$data}}</option>  
                                        @endif
                                        
                                    @endforeach
                                </select>
                              </div>
                            </div>
                        <div class="row">
                            <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#defaultModalPrimary"><li class="fas fa-search"></li> Cari Data</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Cari Data Absen</h5>
                        <h6 class="card-subtitle text-muted">Berdasarkan Bulan & Tahun</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <form action="/cari-bulan" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="">Bulan</label>
                                <select class="form-select" id="" name="bulan">
                                    <?php 
                                    $i =1;
                                    $date = date('m');
                                    ?>
                                    @foreach ($bulan as $data)
                                    @if ($date == $i)
                                        <option value="{{$i++}}" selected>{{$data}}</option>
                                        
                                        
                                        @else
                                        <option value="{{$i++}}">{{$data}}</option>
                                        
                                        @endif
                                    @endforeach
                                </select>
                              </div>
                            </div>
                        <div class="row">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="">Tahun</label>
                                <select class="form-select" id="" name="tahun">
                                    @foreach ($tahun as $data)
                                    @if ($data=='2021')
                                    <option value="{{$data}}" selected>{{$data}}</option>
                                    @else
                                    <option value="{{$data}}">{{$data}}</option>  
                                    @endif
                                    
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#defaultModalPrimary"><li class="fas fa-search"></li> Cari Data</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Cari Data Absen</h5>
                        <h6 class="card-subtitle text-muted">Berdasarkan Tanggal, Bulan & Tahun</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <form action="/cari-tanggal" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Tanggal</span>
                                <input type="number" class="form-control" placeholder="" name="tgl" aria-describedby="basic-addon1">
                              </div>
                        </div>
                        <div class="row">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="">Bulan</label>
                                <select class="form-select" id="" name="bulan">
                                    <?php 
                                    $i =1;
                                    $date = date('m');
                                    ?>
                                    @foreach ($bulan as $data)
                                    @if ($date == $i)
                                        <option value="{{$i++}}" selected>{{$data}}</option>
                                        
                                        
                                        @else
                                        <option value="{{$i++}}">{{$data}}</option>
                                        
                                        @endif
                                    @endforeach
                                </select>
                              </div>
                            </div>
                        <div class="row">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="">Tahun</label>
                                <select class="form-select" id="" name="tahun">
                                    @foreach ($tahun as $data)
                                    @if ($data=='2021')
                                    <option value="{{$data}}" selected>{{$data}}</option>
                                    @else
                                    <option value="{{$data}}">{{$data}}</option>  
                                    @endif
                                    
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                            <button type="submit" class="btn btn-info" data-toggle="modal" ><li class="fas fa-search"></li> Cari Data</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">

            <div class="col-12 col-xl-12">
                <div class="card">
                    
                    <div class="card-header">
                        
                        <h5 class="card-title">Cek Absen hari Ini Tanggal : <?= '<b>'.date('l').' '.date('d/F/Y').'</b>' ?></h5>
                        <h6 class="card-subtitle text-muted">Anda bisa cek semua absensi yang masuk</h6>
                    </div>
                    <table id="tabel" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Waktu</th>
                                <th>Keterangan</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listabsen as $absen)
                                
                                @if ($absen->ket == 'Datang')
                                <tr class="table-success">
                                    <td>
                                        <label for=""><b>{{$absen->nama}}</b></label><br>
                                        <small>{{$absen->nama_amanah.' '.$absen->id_unit}}</small>
                                    </td>
                                    <td>{{$absen->waktu}}</td>
                                    <td>
                                        <li class="fas fa-arrow-circle-down alert-success"></li> {{$absen->ket}}<br>
                                        <small><a href="{{$absen->lokasi}}"><li class="fas fa-map-marker-alt"></li>  Cek Lokasi Absen</a></small>
                                    </td>
                                    <td><a href="{{url('/asset/images/'.$absen->foto)}}" class="btn btn-sm btn-primary"><li class="fa fa-play"></li></a></td>
                                </tr>
                                @else
                                <tr class="table-danger">
                                    <td>
                                        <label for=""><b>{{$absen->nama}}</b></label><br>
                                        <small>{{$absen->nama_amanah.' '.$absen->id_unit}}</small>
                                    </td>
                                    <td>{{$absen->waktu}}</td>
                                    <td>
                                        <li class="fas fa-arrow-circle-up alert-danger" ></li> {{$absen->ket}}<br>
                                        <small><a href="{{$absen->lokasi}}"><li class="fas fa-map-marker-alt"></li>  Cek Lokasi Absen</a></small>
                                    </td>
                                    <td><a href="{{url('/asset/images/'.$absen->foto)}}" class="btn btn-sm btn-primary"><li class="fa fa-play"></li></a></td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            
            
        </div>
    </div>
</main>
@endsection

@section('modal')
<div class="modal fade" id="tambah" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form class="form-horizontal" action="/tambah-karyawan" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Karyawan</label>
                    <div class="col-sm">
                        <input type="text" required="" name="nama" class="form-control" >

                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Unit dan amanah</label>
                    <div class="col-sm">
                        <select name="unit" id="kode_unit" class="form-control">
                            <option value="" disabled selected>-- Pilih Unit & Amanah --</option>
                            
                        </select>
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm control-label">Unit & amanah</label>
                        <div class="row">
                            <div class="col-sm">
                                <input type="text" required="" id="idunit" name="id_unit" class="form-control" readonly>
                            </div>
                            <div class="col-sm">
                                <input type="hidden" required="" id="idamanah" name="id_amanah" class="form-control" readonly value="">
                                <input type="text" required="" id="namaamanah" name="nama_amanah" class="form-control" readonly value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tanggal Masuk</label>
                            <div class="col-sm-6">
                                <input type="date" required="" name="tgl" class="form-control">
                            </div>
                            
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">No HP</label>
                            <div class="col-sm-6">
                                <input type="text" name="no_hp" class="form-control">
                            </div>
                            
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Edit Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form class="form-horizontal" action="/update-karyawan" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Karyawan</label>
                    <div class="col-sm">
                        <input type="text" required="" name="nama_edit" class="form-control" >

                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Unit dan amanah</label>
                    <div class="col-sm">
                        <input type="hidden" required=""  name="id_karyawan" class="form-control" readonly value="">
                        <select name="unit_edit" id="kode_unit_edit" class="form-control">
                            <option value="" disabled selected>-- Pilih Unit & Amanah --</option>
                            
                        </select>
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm control-label">Unit & amanah</label>
                        <div class="row">
                            <div class="col-sm">
                                <input type="text" required="" id="idunit_edit" name="id_unit_edit" class="form-control" readonly>
                            </div>
                            <div class="col-sm">
                                <input type="hidden" required="" id="idamanah_edit" name="id_amanah_edit" class="form-control" readonly value="">
                                <input type="text" required="" id="namaamanah_edit" name="nama_amanah_edit" class="form-control" readonly value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tanggal Masuk</label>
                            <div class="col-sm-6">
                                <input type="date" required="" name="tgl_edit" class="form-control">
                            </div>
                            
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">No HP</label>
                            <div class="col-sm-6">
                                <input type="text" name="no_hp_edit" class="form-control">
                            </div>
                            
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hapus" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form action="/hapus-karyawan" method="post">
                    @csrf
                    <input type="hidden" name="id_hapus" value="">
                    <input type="hidden" name="nama_hapus" value="">
                    <p>Anda Yakin Menghapus?</p><label id="karyawan"></label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

    $('#kode_unit').change(function(){
        kode=$('#kode_unit option:selected').data('kode');
        unit=$('#kode_unit option:selected').data('unit');
        amanah=$('#kode_unit option:selected').data('amanah');
        $('#idunit').val(kode);
        $('#namaamanah').val(unit);
        $('#idamanah').val(amanah);
        console.log(unit);
    });
    $('#kode_unit_edit').change(function(){
        kode=$('#kode_unit_edit option:selected').data('kode');
        unit=$('#kode_unit_edit option:selected').data('unit');
        amanah=$('#kode_unit_edit option:selected').data('amanah');
        $("input[name='id_unit_edit']").val(kode);
        $('#namaamanah').val(unit);
        $("input[name='id_amanah_edit']").val(amanah);
    });
    function edit_karyawan(id, nama, masuk, amanah, id_unit, nohp){
        $("input[name='id_karyawan']").val(id);
        $("input[name='nama_edit']").val(nama);
        $("input[name='id_unit_edit']").val(id_unit);
        $("input[name='id_amanah_edit']").val(amanah);
        $("#kode_unit_edit option[data-amanah='" + amanah + "']").prop("selected", true);
        $("input[name='tgl_edit']").val(masuk);
        $("input[name='no_hp_edit']").val(nohp);

    }
    function hapus_karyawan(id,nama){
        $("input[name='id_hapus']").val(id);
        $("input[name='nama_hapus']").val(nama);
        $("#karyawan").text(nama);
    }
    $(document).ready(function() {
        $('#tabel').DataTable({
            "paging":   false,
                "order": false
        })
        
    } );


    setTimeout(function() {
        $('#message').fadeTo(500, 0).slideUp(500, function(){
                    
            $(this).remove(); 
            });
        }, 6000);
</script>

@endsection