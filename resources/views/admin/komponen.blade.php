@extends('layout/mainadmin')

@section('title','Komponen Gaji')
@section('main')
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Data Komponen</h1>

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
                        <h5 class="card-title">Data komponen gaji</h5>
                        <h6 class="card-subtitle text-muted">Anda bisa manage data komponen</h6>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus-circle"></i> Tambah Value</button>
                    </div>
                    <table id="tabel" class="table table-responsive table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Komponen</th>
                                <th>Nama Komponen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            
                        </tbody>
                    </table>
                </div>
            </div>

            
            
        </div>

    </div>
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Value Komponen</h1>

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
                        <h5 class="card-title">Data value komponen</h5>
                        <h6 class="card-subtitle text-muted">Anda bisa manage data value komponen</h6>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambah_value"><i class="fas fa-plus-circle"></i> Tambah Komponen</button>
                    </div>
                    <table id="tabel" class="table table-responsive table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Komponen</th>
                                <th>Value</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            
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
                <h5 class="modal-title">Form Tambah Komponen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form class="form-horizontal" action="/tambah-karyawan" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Kode Komponen</label>
                    <div class="col-sm-6">
                        <input type="text" required="" name="nama" class="form-control" >

                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Komponen</label>
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
<div class="modal fade" id="tambah_value" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah Value Komponen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form class="form-horizontal" action="/tambah-karyawan" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Kode Komponen</label>
                    <div class="col-sm-6">
                        <input type="hidden" required=""  name="kode_karyawan" class="form-control" readonly value="">
                        <select name="kode_komponen" id="kode_komponen" class="form-control">
                            <option value="" disabled selected>-- Pilih Unit & Amanah --</option>
                            @foreach ($data_unit as $item)
                                <option value="{{$item->id_unit.' - '.$item->nama_amanah.' '.$item->nama_unit}}" data-kode="{{$item->id_unit}}" data-unit="{{$item->nama_unit}}" data-amanah="{{$item->id_amanah}}">{{$item->id_unit.' - '.$item->nama_amanah.' '.$item->nama_unit}}</option>
                            @endforeach
                        </select>

                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Komponen</label>
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
    
    $(document).ready(function() {
        $('#tabel').DataTable()
    } );
    setTimeout(function() {
        $('#message').fadeTo(500, 0).slideUp(500, function(){
                    
        $(this).remove(); 
        });
    }, 6000);
</script>

@endsection