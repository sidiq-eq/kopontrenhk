@extends('layout/mainadmin')

@section('title','Unit Usaha')
@section('main')
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Data Unit Usaha</h1>

        <div class="row">

            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        @if (session('status'))
                            <div class="alert {{session('alert-class')}} alert-dismissible" role="alert" id="message">
                                
                                <div class="alert-message">
                                    <b>{{session('status')}}</b>
                                </div>
                            </div>
                        @endif
                        <h5 class="card-title">Berikut data unit kopontren HK</h5>
                        <h6 class="card-subtitle text-muted">Anda bisa manage data unit usaha</h6>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambah_unit"><i class="fas fa-business-time""></i> Tambah Unit</button> | <button class="btn btn-success" data-toggle="modal" data-target="#tambah_amanah"><i class="fas fa-user-tie"></i> Tambah Amanah</button> | <button class="btn btn-outline-primary" data-toggle="modal" data-target="#daftarkan_unit"><i class="fas fa-plus-circle"></i> Daftarkan Unit</button> | <button class="btn btn-outline-danger" data-toggle="modal" data-target="#hapusdaftar_unit"><i class="fa fa-minus-circle"></i> Hapus Daftar Unit</button>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Unit Usaha</th>
                                <th>Status</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $unit)
                                
                            
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$unit->id_unit}}
                                </td>
                                <td>{{$unit->nama_unit}}</td>
                                <td>{{$unit->status}}</td>
                                
                                <td>
                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#update_unit" data-id="{{$unit->id_unit}}" data-nama="{{$unit->nama_unit}}" onclick="update_unit('{{$unit->id_unit}}','{{$unit->nama_unit}}')"><li class="fa fa-pen"></li></button>
                                    <a href="{{url('#')}}" class="btn btn-sm btn-danger"data-toggle="modal" data-target="#hapus_unit" onclick="hapus_unit('{{$unit->id_unit}}','{{$unit->nama_unit}}')"><li class="fa fa-trash"></li></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            
            
        </div>
        <h1 class="h3 mb-3">Data Amanah Usaha</h1>
        <div class="row">

            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        
                        <h5 class="card-title">Berikut data amanah kopontren HK</h5>
                        <h6 class="card-subtitle text-muted">Anda bisa manage data amanah usaha</h6>
                    </div>
                    <table id="tabel" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Amanah</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data2 as $amanah)
                                
                            
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$amanah->id_unit}}
                                </td>
                                <td>{{$amanah->nama_amanah.' '.$amanah->nama_unit}}</td>
                                
                                <td>
                                    <a href="{{url('#')}}" class="btn btn-sm btn-danger"data-toggle="modal" data-target="#hapus_amanah" onclick="hapus_amanah('{{$amanah->id_amanah}}','{{$amanah->nama_amanah}}')"><li class="fa fa-trash"></li></a>

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
<div class="modal fade" id="update_unit" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-business-time""></i> Form Edit Unit Usaha</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form class="form-horizontal" action="/unit/edit_unit" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Kode Unit</label>
                    <div class="col-sm">
                        <input type="text" required="" name="id" class="form-control" readonly>

                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Unit Usaha</label>
                    <div class="col-sm">
                        <input type="text" required="" name="nama" class="form-control" >

                    </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah_unit" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-business-time""></i> Form Tambah Unit Usaha</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form class="form-horizontal" action="/unit/tambah_unit" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Kode Unit</label>
                    <div class="col-sm">
                        <input type="text" required="" name="id" class="form-control" >

                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Unit Usaha</label>
                    <div class="col-sm">
                        <input type="text" required="" name="nama" class="form-control" >

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
<div class="modal fade" id="daftarkan_unit" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Daftarkan Unit Usaha</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <p>Mendaftarkan Unit Usaha adalah dimana unit usaha membutuhkan laporan secara realtime ke system</p>
                <form class="form-horizontal" action="/unit/daftarkan" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Kode Unit</label>
                    <div class="col-sm">
                        <select name="id" id="" class="form-control">
                            <option value="" disabled selected>-- Pilih Unit --</option>
                            @foreach ($data as $item)
                            <option value="{{$item->id_unit}}">{{$item->nama_unit}}</option>
                            @endforeach
                        </select>
                        
                    </div>
                    </div>
                    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hapusdaftar_unit" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Hapus Daftar Unit Usaha</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <p>Menghapus Daftar berarti </p>
                <form class="form-horizontal" action="/unit/hapusdaftar" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Kode Unit</label>
                    <div class="col-sm">
                        <select name="id" id="" class="form-control">
                            <option value="" disabled selected>-- Pilih Unit --</option>
                            @foreach ($data as $item)
                            <option value="{{$item->id_unit}}">{{$item->nama_unit}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                        
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hapus_unit" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Unit Usaha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form action="unit/hapus_unit" method="post">
                    @csrf
                    <p>Anda Yakin Menghapus?</p><label id="hapus_unit_label"></label>
                    <input type="hidden" name="id" id="id_hapus_unit" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah_amanah" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-user-tie"></i> Form Tambah Amanah</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form class="form-horizontal" action="/unit/tambah_amanah" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Pilih Unit usaha</label>
                        <div class="row">

                            <div class="col-sm">
                                <select name="kode" id="kode" class="form-control">
                                    <option value="" disabled selected>-- Pilih Unit --</option>
                                    @foreach ($data as $item)
                                        <option value="{{$item->id_unit}}" data-kode="{{$item->id_unit}}" data-unit="{{$item->nama_unit}}">{{$item->id_unit}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="col-sm-6">
                                <input type="text" id="nama_unit" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Amanah</label>
                    <div class="col-sm">
                        <input type="text" required="" name="nama" class="form-control" >

                    </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hapus_amanah" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Amanah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form action="unit/hapus_amanah" method="post">
                    @csrf
                    <p>Anda Yakin Menghapus?</p><label id="hapus_amanah_label"></label>
                    <input type="hidden" name="id" id="id_hapus_amanah" value="">
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
    setTimeout(function() {
        $('#message').fadeTo(500, 0).slideUp(500, function(){
                    
        $(this).remove(); 
        });
    }, 6000);
    function update_unit(id,nama){
        $("input[name='id']").val(id);
        $("input[name='nama']").val(nama);
        
    }
    function hapus_unit(id,nama){
        $("input[name='id']").val(id);
        $("#hapus_unit_label").text(nama);
        
    }
    function hapus_amanah(id,nama){
        $("#id_hapus_amanah").val(id);
        $("#hapus_amanah_label").text(nama);
        
    }

$(document).ready(function(){
    $('#kode').change(function(){
        kode=$('#kode option:selected').data('kode');
        unit=$('#kode option:selected').data('unit');
        $('#id_unit').val(kode);
        $('#nama_unit').val(unit);
        console.log(unit);
    });
    


    $('#hapus_unit').on('shown', function(event){
        var unit = $(event.relatedTarget);
        var id_unit = unit.data('id');
        var nama_unit = unit.data('nama');
        var modal = $(this);
        console.log(id_unit,nama_unit);
        modal.find('.modal-body #id_hapus_unit').val(id_unit);
        modal.find('.modal-body #hapus_unit_id').val(nama_unit);
        });
    });
    
    $(document).ready(function() {
        $('#tabel').DataTable()
    } );
</script>

@endsection