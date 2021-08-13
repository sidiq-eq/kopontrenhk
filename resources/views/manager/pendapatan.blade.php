@extends('layout/mainmanager')

@section('title','Pendapatan')
@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">

                <h1 class="h3 mb-3">Buat Laporan</h1>
            </div>
            <div class="col-6 ">
                <a href="{{url('/form-pendapatan')}}" class="btn btn-xs btn-outline-primary float-right"><li class="fa fa-arrow-right"></li> Form Input</a>
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
                        <form action="/buat-pendapatan-unit" method="post">
                            @csrf
                            <div class="row">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="">Unit</label>
                                    <select  class="form-control" disabled>
										
											<option value="<?= $user->id_unit ?>"><?= $user->nama_unit ?></option>
											<input type="hidden" name="unit" value="<?= $user->id_unit ?>">
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
        <h1 class="h3 mb-3">Grafik Pendapatan</h1>
        <div class="row">
            <div class="col-12">
                
                    <div class="card flex-fill w-100">
                        <div class="card-header">
    
                            <h5 class="card-title mb-0">Pendapatan 14 Hari Terakhir</h5>
                        </div>
                        <div class="card-body py-3">
                            <div class="chart chart-sm"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                <canvas id="chartjs-dashboard-line" style="display: block; width: 453px; height: 252px;" width="453" height="252" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
        <h1 class="h3 mb-3">Data Pendapatan</h1>

        <div class="row">

            <div class="col-xl-7 col-xs-12">
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
                        <h5 class="card-title">Berikut data pendapatan {{$user->nama_unit}}</h5>
                        <h6 class="card-subtitle text-muted">Anda bisa manage data Pendapatan</h6>
                        
                    </div>
                        <table id="tabel" class="table table-responsive table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th class="alert-success"><center>Pendapatan</center></th>
                                    <th class="alert-danger"><center>Kasbon</center></th>
                                    <th class="alert-info"><center>Total</center></th>
                                    <th><center>aksi</center></th>
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
                                    <td>{{$loop->iteration}}</td>
                                    <td nowrap>{{$tgl}}</td>
                                    <td class="alert-success" nowrap><li class="fas fa-arrow-circle-down alert-success"> </li><b>{{' '.$pendapatan}}</b></span></td>
                                    <td class="alert-danger" nowrap><li class="fas fa-arrow-circle-up alert-danger"> </li><b>{{' '.$kasbon}}</b></td>
                                    <td class="alert-info" nowrap><b>{{$total}}</b></td>
                                    <td nowrap>
                                        <button type="button" class="btn btn-sm btn-warning" onclick="edit_pendapatan('{{$data->tgl}}','{{$data->pendapatan}}','{{$data->kasbon}}', '{{$data->total}}');"><li class="fa fa-pen"></li></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>

            
            
        </div>
        <h1 class="h3 mb-3">Grafik Konsinyasi</h1>
        <div class="row">
            <div class="col-12">
                
                    <div class="card flex-fill w-100">
                        <div class="card-header">
    
                            <h5 class="card-title mb-0">Pendapatan 14 Hari Terakhir</h5>
                        </div>
                        <div class="card-body py-3">
                            <div class="chart chart-sm"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                <canvas id="chartjs-dashboard-line2" style="display: block; width: 453px; height: 252px;" width="453" height="252" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
        <h1 class="h3 mb-3">Data Konsinyasi</h1>

        <div class="row">

            <div class="col-xl-6 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        
                        <h5 class="card-title">Berikut data konsinyasi {{$user->nama_unit}}</h5>
                        <h6 class="card-subtitle text-muted">Anda bisa manage data konsinyasi</h6>
                        
                    </div>
                        <table id="tabel2" class="table table-responsive table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th class="alert-info"><center>Total</center></th>
                                    <th><center>aksi</center></th>
                                </tr>
                            </thead>
                            <tbody>
    
                                @foreach ($konsinyasi as $data)
                                <?php 
                                $tgl = date("d-m-Y", strtotime($data->tgl));
                                
                                $total = 'Rp. '.number_format($data->total,0,'','.');
                                ?>
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td nowrap>{{$tgl}}</td>
                                    <td class="alert-info" nowrap><b>{{$total}}</b></td>
                                    <td nowrap>
                                        <button type="button" class="btn btn-sm btn-warning"><li class="fa fa-pen"></li></button>
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

<div class="modal fade" id="edit" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pendapatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <p>

                </p>
                <form class="form-horizontal" action="/ubah-karyawan" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Karyawan</label>
                    <div class="col-sm">
                        <input type="hidden" required="" name="tgl" class="form-control" >

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

@endsection

@section('script')
<script>

    
        
        
document.addEventListener("DOMContentLoaded", function() {
        let rupiahFormat = Intl.NumberFormat('id-ID');
        var cData = JSON.parse(`<?php echo $chart_data; ?>`);
        var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
        gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
        // Line chart
        new Chart(document.getElementById("chartjs-dashboard-line"), {
            type: "line",
            data: {
                labels: cData.label,
                datasets: [{
                    label: "Rp. ",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: window.theme.primary,
                    data: cData.data
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    intersect: false
                },
                hover: {
                    intersect: true
                },
                plugins: {
                    filler: {
                        propagate: false
                    }
                },
                scales: {
                    xAxes: [{
                        reverse: true,
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 1000000
                        },
                        display: true,
                        borderDash: [3, 3],
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }]
                }
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        let rupiahFormat = Intl.NumberFormat('id-ID');
        var cData = JSON.parse(`<?php echo $chart_data2; ?>`);
        var ctx = document.getElementById("chartjs-dashboard-line2").getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
        gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
        // Line chart
        new Chart(document.getElementById("chartjs-dashboard-line2"), {
            type: "line",
            data: {
                labels: cData.label,
                datasets: [{
                    label: "Rp. ",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: window.theme.primary,
                    data: cData.data
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    intersect: false
                },
                hover: {
                    intersect: true
                },
                plugins: {
                    filler: {
                        propagate: false
                    }
                },
                scales: {
                    xAxes: [{
                        reverse: true,
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 5000000
                        },
                        display: true,
                        borderDash: [3, 3],
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }]
                }
            }
        });
    });

function edit_pendapatan(tgl, pendapatan, kasbon, total){
        var today = new Date();
        var dd = today.getDate();

        var mm = today.getMonth()+1; 
        var yyyy = today.getFullYear();
            if(dd<10) 
            {
                dd='0'+dd;
            } 

            if(mm<10) 
            {
                mm='0'+mm;
            } 
        sekarang = yyyy+'-'+mm+'-'+dd;
        console.log(sekarang+' '+tgl);
        if(tgl==sekarang){
            alert('tidak dapat diubah sudah kadaluarsa');
        }else{
            $("#edit").modal('show');
        }

        
        

    }
    
$(document).ready(function() {
        $('#tabel').DataTable( {
            "sScrollX": '100%'
        } );
        $('#tabel2').DataTable( {
            "sScrollX": '100%'
        } );
    } );
    setTimeout(function() {
        $('#message').fadeTo(500, 0).slideUp(500, function(){
                    
        $(this).remove(); 
        });
    }, 6000);
</script>

@endsection