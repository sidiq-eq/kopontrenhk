@extends('layout/mainmanager')

@section('title','Karyawan')
@section('main')
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Data Karyawan</h1>

        <div class="row">

            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        @if (session('status'))
                            <div class="alert {{session('alert-class')}} alert-dismissible" role="alert" id="message">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <div class="alert-message">
                                    <b>{{session('status')}}</b>
                                </div>
                            </div>
                        @endif
                        <h5 class="card-title">Berikut data karyawan {{$user->nama_unit}}</h5>
                        <h6 class="card-subtitle text-muted">Anda bisa manage data karyawan</h6>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="far fa-user"></i> Tambah Karyawan</button>
                    </div>
                        <table id="tabel" class="table table-responsive table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><center>Nama & Amanah</center></th>
                                    <th><center>Masa Kerja</center></th>
                                    <th nowrap><center>No HP</center></th>
                                    <th><center>aksi</center></th>
                                </tr>
                            </thead>
                            <tbody>
    
                                @foreach ($data_karyawan as $karyawan)
                                <?php 
                                $tgl = date('Ymd');
    
                                $ts1 = strtotime($karyawan->masuk);
                                $ts2 = strtotime($tgl);
    
                                $year1 = date('Y', $ts1);
                                $year2 = date('Y', $ts2);
    
                                $month1 = date('m', $ts1);
                                $month2 = date('m', $ts2);
    
                                $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                                ?>    
                                
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td nowrap><b>
                                        {{$karyawan->nama}}</b>
                                        <br>
                                        <small>{{$karyawan->id_unit.' ('.$karyawan->nama_amanah.')'}}</small>
                                    </td nowrap>
                                    
                                    <td nowrap>{{$karyawan->masuk.' ('.$diff.' Bulan)'}}</td>
                                    <td nowrap>{{$karyawan->no_hp}}</td>
                                    
                                    <td nowrap>
                                        <a href="" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit" onclick="edit_karyawan('{{$karyawan->id_karyawan}}','{{$karyawan->nama}}','{{$karyawan->masuk}}', '{{$karyawan->id_amanah}}','{{$karyawan->id_unit}}',  '{{$karyawan->no_hp}}');"><li class="fa fa-pen"></li></a>
                                        <a href="" class="btn btn-sm btn-danger"data-toggle="modal" onclick="hapus_karyawan('{{$karyawan->id_karyawan}}','{{$karyawan->nama}}');" data-id="{{$karyawan->id_karyawan}}" data-nama="{{$karyawan->nama}}" data-target="#hapus"><li class="fa fa-trash"></li></a>
                                    </td>
                                </tr>
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
                <form class="form-horizontal" action="/karyawan-manager" method="post">
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
                            @foreach ($data_unit as $item)
                                <option value="{{$item->id_unit.' - '.$item->nama_amanah.' '.$item->nama_unit}}" data-kode="{{$item->id_unit}}" data-unit="{{$item->nama_unit}}" data-amanah="{{$item->id_amanah}}">{{$item->id_unit.' - '.$item->nama_amanah.' '.$item->nama_unit}}</option>
                            @endforeach
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
                <form class="form-horizontal" action="/ubah-karyawan" method="post">
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
                            @foreach ($data_unit as $item)
                                <option value="{{$item->id_unit.' - '.$item->nama_amanah.' '.$item->nama_unit}}" data-kode="{{$item->id_unit}}" data-unit="{{$item->nama_unit}}" data-amanah="{{$item->id_amanah}}">{{$item->id_unit.' - '.$item->nama_amanah.' '.$item->nama_unit}}</option>
                            @endforeach
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
                <form action="/del-karyawan" method="post">
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
        $('#tabel').DataTable( {
        "scrollX": true
        } );
    } );
    setTimeout(function() {
        $('#message').fadeTo(500, 0).slideUp(500, function(){
                    
        $(this).remove(); 
        });
    }, 6000);
</script>

@endsection