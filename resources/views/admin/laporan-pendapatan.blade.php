@extends('layout/mainadmin')

@section('title','Cek Absensi')
@section('main')
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Laporan Pendapatan</h1>
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
                        <h5 class="card-title">Buat Laporan Pendapatan</h5>
                        <h6 class="card-subtitle text-muted">Pendapatan, Konsinyasi</h6>
                    </div>
                    <div class="card-body text-center">
                        <form action="/buat-pendapatan" method="post">
                            @csrf
                            <div class="row">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="">Unit</label>
                                    <select class="form-select" id="" name="unit">
                                    <option selected disabled>-- Pilih Unit --</option>
                                    @foreach ($terdaftar as $data)
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
                            <button type="submit" class="btn btn-info"><li class="fas fa-search"></li> Cari Data</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        
    </div>
</main>
@endsection

@section('modal')
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