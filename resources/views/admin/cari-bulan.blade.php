@extends('layout/mainadmin')

@section('title','Cari Absen karyawan')
@section('main')
<main class="content">
    <div class="container-fluid p-0" id="printableArea">

        <h1 class="h3 mb-3">Data Absen </h1>

        <div class="row">

            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <div class="alert-message">
                                    <b>{{session('status')}}</b>
                                </div>
                            </div>
                        @endif
                        <h5 class="card-title">Berikut data absen bulan : </h5>
                        <h6 class="card-subtitle text-muted">tahun :</h6>
                    </div>
                    <div class="row">
                        <div class="container">
                            <a class="btn btn-info btn-sm" href="{{url('/list_absen')}}"><i class="fa fa-arrow-left"></i> Back</a>
                                <button class="btn btn-primary btn-sm" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                    <table id="tabel" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Waktu</th>
                                <th>Tanggal</th>
                                <th>ket</th>
                                <th>foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_absen as $absen)
                                @if ($absen->ket == 'Datang')
                                <tr class="table-success">
                                    <td>
                                        <label for=""><b>{{$absen->nama}}</b></label><br>
                                        <small>{{$absen->id_unit}}</small>
                                    </td>
                                    <td>{{$absen->waktu}}</td>
                                    <?php 
                                    $tanggal = date('d/m/Y',strtotime($absen->tgl));
                                    ?>
                                    <td>{{$tanggal}}</td>
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
                                        <small>{{$absen->id_unit}}</small>
                                    </td>
                                    <td>{{$absen->waktu}}</td>
                                    <?php 
                                    $tanggal = date('d/m/Y',strtotime($absen->tgl));

                                    ?>
                                    <td>{{$tanggal}}</td>
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

@endsection

@section('script')
<script>
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
    }
    $(document).ready(function() {
        $('#tabel').DataTable()
    } );
</script>

@endsection