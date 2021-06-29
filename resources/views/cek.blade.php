@extends('layout/main')

@section('title','Cek Absensi')
@section('main')
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Cek Absen</h1>

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
                            @foreach ($data_absen as $absen)
                                
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
@section('script')
<script>

    $(document).ready(function() {
        $('#tabel').DataTable(
            {
                "paging":   false,
                "order": false
            }
            
        );
    } );

    setTimeout(function() {
        $('#message').fadeTo(500, 0).slideUp(500, function(){
                    
        $(this).remove(); 
        });
    }, 6000);
</script>

@endsection