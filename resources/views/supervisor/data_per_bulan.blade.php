@extends('layout/mainsupervisor')

@section('title','Pendapatan & Konsinyasi')
@section('main')
<main class="content">
    <div class="container-fluid p-0">

        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong></strong> Pendapatan & Konsinyasi</h3>
            </div>

            
        </div>
        <div class="row">
                
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4"> Nama Unit Usaha</h5>
                            <div class="row">
                                <div class="col-6">

                                    <h3 class="mt-1 mb-3 text-secondary" ><i class="fas fa-business-time""></i>{{' '.$unit->nama_unit}}</h3>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-primary btn-block" onclick="btn_print()"><i class="fa fa-print"></i> Print</button>
                                    
                                </div>
                                <div class="col-3">
                                    
                                    <button  class="btn btn-danger btn-block" onclick="btn_pdf()"><i class="fa fa-file"></i> PDF</button>
                                </div>

                            </div>
                            <div class="mb-1">
                                <span class="text-muted">ID Unit : {{$unit->id_unit}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                        
            </div>     
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3> Pendapatan</h3>
                        <h5 class="card-title mb-4"> Ringkasan Pendapatan</h5>
                        <div class="row">
                            <div class="col-3">
                                <center><h5 >Jumlah<br><b class="text-info">{{$sum}}</b></h5></center>
                                
                            </div>
                            <div class="col-3">
                                <center><h5>Rata-rata<br><b class="text-primary">{{$avg}}</b></h5></center>
                                
                            </div>
                            <div class="col-3">
                                <center><h5>Tertinggi<br><b class="text-success">{{$max}}</b></h5></center>
                                
                            </div>
                            <div class="col-3">
                                <center><h5>Terendah<br><b class="text-danger">{{$min}}</b></h5></center>
                                
                            </div>

                        </div>
                        <div class="mb-1">
                            <span class="text-muted">Ringkasan Pendapatan Bulan : {{$bulan}} Tahun : {{$tahun}}</span>
                        </div>
                    </div>
                </div>
            </div>
  
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card flex-fill w-100">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Pendapatan Bulan {{$bulan}} Tahun {{$tahun}}</h5>
                    </div>
                    <div class="card-body py-3">
                        <div class="chart chart-sm"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="chartjs-dashboard-line" style="display: block; width: 453px; height: 252px;" width="453" height="252" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-12">
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
                        <h5 class="card-title">Berikut data pendapatan {{$unit->nama_unit}} Bulan : {{$bulan}} Tahun : {{$tahun}}</h5>
                        
                    </div>
                        <table id="tabel" class="table table-responsive table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th class="alert-success">Pendapatan</th>
                                    <th class="alert-danger">Kasbon</th>
                                    <th class="alert-info">Total</th>
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
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>

            
            
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3> Konsinyasi</h3>
                        <h5 class="card-title mb-4"> Ringkasan Konsinyasi</h5>
                        <div class="row">
                            <div class="col-3">
                                <center><h5 >Jumlah<br><b class="text-info">{{$sum2}}</b></h5></center>
                                
                            </div>
                            <div class="col-3">
                                <center><h5>Rata-rata<br><b class="text-primary">{{$avg2}}</b></h5></center>
                                
                            </div>
                            <div class="col-3">
                                <center><h5>Tertinggi<br><b class="text-success">{{$max2}}</b></h5></center>
                                
                            </div>
                            <div class="col-3">
                                <center><h5>Terendah<br><b class="text-danger">{{$min2}}</b></h5></center>
                                
                            </div>

                        </div>
                        <div class="mb-1">
                            <span class="text-muted">Ringkasan Konsinyasi Bulan : {{$bulan}} Tahun : {{$tahun}}</span>
                        </div>
                    </div>
                </div>
            </div>
  
        </div>
        <div class="row">
            <div class="col-12">
                
                    <div class="card flex-fill w-100">
                        <div class="card-header">
    
                            <h5 class="card-title mb-0">Konsinyasi {{$unit->nama_unit}} Bulan : {{$bulan}} Tahun : {{$tahun}}</h5>
                        </div>
                        <div class="card-body py-3">
                            <div class="chart chart-sm"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                <canvas id="chartjs-dashboard-line2" style="display: block; width: 453px; height: 252px;" width="453" height="252" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>

        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        
                        <h5 class="card-title">Berikut data konsinyasi {{$unit->nama_unit}} Bulan : {{$bulan}} Tahun : {{$tahun}}</h5>
                        
                    </div>
                        <table id="tabel2" class="table table-responsive table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th class="alert-info">Total</th>
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
    
    

    function btn_print() {
        window.print();
    }
    function btn_pdf() {
        alert('Error, Untuk saat ini fitur PDF belum bisa di gunakan, sementara bisa klik button print > pilih tujuan Save as PDF');
    }
    
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
                    display: false,
                    
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
    
</script>


<script>
    $(document).ready(function() {
        $('#tabel').DataTable( {
            "paging":   false,
            "ordering": false,
            "searching": false
        } );
        $('#tabel2').DataTable( {
            "paging":   false,
            "ordering": false,
            "searching": false
        } );
    } );
    
</script>
@endsection