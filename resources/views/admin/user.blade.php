@extends('layout/mainadmin')

@section('title','User')
@section('main')
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Data User</h1>

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
                        <h5 class="card-title">Berikut data user yang bisa masuk system</h5>
                        <h6 class="card-subtitle text-muted">Anda bisa manage data user</h6>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="far fa-user"></i> Tambah User</button>
                    </div>
                    <table id="tabel" class="table table-responsive table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->username}}</td>
                                    <td>{{$data->password}}</td>
                                    <?php $level = $data->level ?>
                                    <?php if ($level == 1): ?>
                                    <td>1 (Admin)</td>
                                    <?php elseif ($level == 2): ?>
                                    <td>2 (Karyawan)</td>
                                    <?php elseif ($level == 3): ?>
                                    <td>3 (Manager)</td>
                                    <?php else : ?>
                                    <td>4 (Supervisor)</td>
                                    <?php endif; ?>
                                    <td>
                                        <a href="" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit" onclick="edit_karyawan();"><li class="fa fa-pen"></li></a>
                                        <a href="" class="btn btn-sm btn-danger"data-toggle="modal" onclick="hapus_karyawan();" data-id="" data-nama="" data-target="#hapus"><li class="fa fa-trash"></li></a>
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
                <h5 class="modal-title">Form Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form class="form-horizontal" action="/tambah-user" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Level</label>
                    <div class="col-sm">
                        <select name="level" id="level" class="form-control">
                            <option value="" disabled selected>-- Pilih Level --</option>
                            <option value="1">1. Admin</option>
                            <option value="2">2. User</option>
                            <option value="3">3. Manager</option>
                            <option value="4">4. SPV</option>
                        </select>
                    </div>
                    </div>
                    <div class="form-group" id="unit" style="display: none">
                        <label class="col-sm-4 control-label">Unit</label>
                    <div class="col-sm">
                        <select name="unit" class="form-control">
                            <option value="" disabled selected>-- Pilih Unit --</option>
                            @foreach ($data_unit as $item)
                                <option value="{{$item->id_unit}}">{{$item->nama_unit}}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama User</label>
                    <div class="col-sm">
                        <input type="text" id="nama" name="nama" value="" class="form-control">
                        <select name="karyawan" id="karyawan" class="form-control" style="display: none">
                            <option value="" disabled selected>-- Pilih Karyawan --</option>
                            @foreach ($data_karyawan as $item)
                                <option value="{{$item->id_karyawan}}" data-kode="{{$item->id_karyawan}}" data-nama="{{$item->nama}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="nama_karyawan" name="nama_karyawan" class="form-control">
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Username</label>
                    <div class="col-sm">
                        <input type="text" required="" name="username" class="form-control" >

                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Password</label>
                    <div class="col-sm">
                        <input type="password" required="" name="password" class="form-control" >

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
    $('#level').on('change', function() {
        console.log(this.value);
        if(this.value == 1){
            $("#nama").css("display","block");
            $("#karyawan").css("display","none");
            $("#unit").css("display","none");
        }else if(this.value == 2){
            
            $("#nama").css("display","none");
            $("#karyawan").css("display","block");
            $("#unit").css("display","none");
        }else if(this.value == 3){
            $("#nama").css("display","block");
            $("#karyawan").css("display","none");
            $("#unit").css("display","block");
        }else {
            $("#nama").css("display","block");
            $("#karyawan").css("display","none");
            $("#unit").css("display","none");
        }
    });
    $(document).ready(function() {
        $('#tabel').DataTable();

        $('#karyawan').change(function(){
        kode=$('#karyawan option:selected').data('kode');
        nama=$('#karyawan option:selected').data('nama');
        $('[name="nama_karyawan"]').val(nama);
        $('[name="nama"]').css('display','block');
        $('[name="nama"]').attr('type','hidden');
        $('[name="nama"]').val(nama);
    });
    } );
    setTimeout(function() {
        $('#message').fadeTo(500, 0).slideUp(500, function(){
                    
        $(this).remove(); 
        });
    }, 6000);
</script>

@endsection