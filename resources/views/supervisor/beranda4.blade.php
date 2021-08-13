@extends('layout/mainsupervisor')

@section('title','Beranda')
@section('main')
<main class="content">
    <div class="container-fluid p-0">

        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong></strong> Dashboard</h3>
            </div>

            
        </div>
        <div class="row">
            <div class="col-xl-12 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Ahlan wa sahlan</h5>
                                    <h3 class="mt-1 mb-3 text-secondary"><li class="fas fa-user"></li> Supervisor</h3>

                                    <div class="mb-1">
                                        <span class="text-muted text-success">"Semoga harimu selalu di berkahi dan di lingdungi Allah Azza Wa Jalla"</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4"> Waktu dan tanggal</h5>
                                    <h3 class="mt-1 mb-3 text-secondary" ><i class="fas fa-business-time""></i>{{date('d M Y')}}</h3>
                                    <div class="mb-1">
                                        <span class="text-muted">Waktu saat ini : {{date('H:m:s')}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Cek Pendapatan & Data Unit</h5>
                                    
                                    
                                    <h3 class="mt-1 mb-3"><a href="{{url('cek-data')}}" class="text-success"><li class="fas fa-arrow-circle-right"></li> Menu Data</a></h3>
                                    
                                    <div class="mb-1">
                                        <span class="text-muted">Shortcut ke Menu Data</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Cek Slip Penggajian</h5>
                                    
                                    
                                    <h3 class="mt-1 mb-3 text-success"><a href="{{url('gaji')}}" class="text-warning"><li class="fas fa-arrow-circle-right"></li> Menu Penggajian</a></h3>
                                    
                                    <div class="mb-1">
                                        <span class="text-muted">Shortcut ke Menu Penggajian</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
        </div>

        

        <div class="row">
            <div class="col-xl-6 d-flex col-xs-12">
                <div class="card flex-fill">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Terakhir Pendapatan</h5>
                    </div>
                    <table id="tabel" class="table table-responsive table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th class="alert-success"><center>Unit</center></th>
                                <th class="alert-success"><center>Pendapatan</center></th>
                                <th class="alert-danger"><center>Kasbon</center></th>
                                <th class="alert-info"><center>Total</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendapatan as $data)
                            <?php 
                            $tgl = date("d-m-Y", strtotime($data->tgl));
                            $pendapatan = ''.number_format($data->pendapatan,0,'','.');
                            $kasbon = ''.number_format($data->kasbon,0,'','.');
                            $total = 'Rp. '.number_format($data->total,0,'','.');
                            ?>
                            <tr>
                                <td nowrap>{{$tgl}}</td>
                                <td>{{$data->id_unit}}</td>
                                <td class="alert-success" nowrap><li class="fas fa-arrow-circle-down alert-success"> </li><b>{{' '.$pendapatan}}</b></span></td>
                                <td class="alert-danger" nowrap><li class="fas fa-arrow-circle-up alert-danger"> </li><b>{{' '.$kasbon}}</b></td>
                                <td class="alert-info" nowrap><b>{{$total}}</b></td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xl-6 d-flex col-xs-12">
                <div class="card flex-fill">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Terakhir Absen</h5>
                    </div>
                    <table id="tabel2" class="table table-responsive table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Waktu</th>
                                <th>Ket</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absen as $data)
                            <?php 
                            $tgl = date("d-m-Y", strtotime($data->tgl));?>
                                    @if ($data->ket == 'Datang')
                                    <tr class="table-success">
                                        <td nowrap>{{$tgl}}</td>
                                        <td style="text-overflow: ellipsis;">
                                            <label for=""><b>{{$data->nama}}</b></label><br>
                                        </td>
                                        <td>{{$data->waktu}}</td>
                                        <td nowrap>
                                            <li class="fas fa-arrow-circle-down alert-success"></li> {{$data->ket}}<br>
                                            <small><a href="{{$data->lokasi}}"><li class="fas fa-map-marker-alt"></li>  Cek Lokasi</a></small>
                                        </td>
                                        <td><a href="{{url('/asset/images/'.$data->foto)}}" class="btn btn-sm btn-primary"><li class="fa fa-play"></li></a></td>
                                    </tr>
                                    @else
                                    <tr class="table-danger">
                                        <td>
                                            <td nowrap>{{$tgl}}</td>
                                            <label for=""><b>{{$data->nama}}</b></label><br>
                                        </td>
                                        <td nowrap>{{$data->waktu}}</td>
                                        <td nowrap>
                                            <li class="fas fa-arrow-circle-up alert-danger" ></li> {{$data->ket}}<br>
                                            <small><a href="{{$data->lokasi}}"><li class="fas fa-map-marker-alt"></li>  Cek Lokasi</a></small>
                                        </td>
                                        <td><a href="{{url('/asset/images/'.$data->foto)}}" class="btn btn-sm btn-primary"><li class="fa fa-play"></li></a></td>
                                    </tr>
                                    @endif
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 d-flex col-xs-12">
                <div class="card flex-fill">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Terakhir Konsinyasi</h5>
                    </div>
                    <table id="tabel3" class="table table-responsive table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Unit</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($konsinyasi as $data)
                            <?php 
                            $tgl = date("d-m-Y", strtotime($data->tgl));
                            
                            $total = 'Rp. '.number_format($data->total,0,'','.');
                            ?>
                            <tr>
                                <td nowrap>{{$tgl}}</td>
                                <td nowrap><b>{{$data->id_unit}}</b></td>
                                <td class="alert-info" nowrap><b>{{$total}}</b></td>
                                
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
@section('script')
<script>
    
    
        
        
</script>


<script>
    $(document).ready(function() {
        $('#tabel').DataTable( {
            "sScrollX": '100%',
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false
        } );
        $('#tabel2').DataTable( {
            "sScrollX": '100%',
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false
        } );
        $('#tabel3').DataTable( {
            "sScrollX": '100%',
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false
        } );
        
    } );
    
</script>
@endsection