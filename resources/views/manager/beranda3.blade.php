@extends('layout/mainmanager')

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
            <div class="col-xl-12 col-xxl-5 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Ahlan wa sahlan</h5>
                                    <h3 class="mt-1 mb-3 text-secondary"><li class="fas fa-user"></li>{{' '.$user->name}}</h3>

                                    <span class="mt-1 mb-3 ">Amanah : Manager {{$user->nama_unit}}</span>
                                    <div class="mb-1">
                                        <span class="text-muted text-success">"Semoga harimu selalu di berkahi dan di lingdungi Allah Azza Wa Jalla"</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4"> Nama Unit Usaha</h5>
                                    <h3 class="mt-1 mb-3 text-secondary" ><i class="fas fa-business-time""></i>{{' '.$user->nama_unit}}</h3>
                                    <div class="mb-1">
                                        <span class="text-muted">ID Unit : {{$user->id_unit}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Status Laporan hari ini</h5>
                                    <?php if($status == 0) :?>
                                    <h3 class="mt-1 mb-3 text-danger"><li class="fas fa-times-circle"></li> Anda Belum Laporan</h3>
                                    <?php else : ?>
                                    <h3 class="mt-1 mb-3 text-success"><li class="fas fa-check-circle"></li> Anda Sudah Laporan</h3>
                                    <?php endif; ?>
                                    <div class="mb-1">
                                        <span class="text-muted">Status saat ini</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Buat Laporan Pendapatan</h5>
                                    
                                    
                                    <h3 class="mt-1 mb-3"><a href="{{url('/form-pendapatan')}}" class="text-success"><li class="fas fa-arrow-circle-right"></li> Menu Input Laporan</a></h3>
                                    
                                    <div class="mb-1">
                                        <span class="text-muted">Shortcut ke Menu Input Pendapatan</span>
                                    </div>
                                </div>
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
                                <span class="text-muted">Ringkasan Pendapatan 7 hari terakhir</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card flex-fill w-100">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Pendapatan 7 Hari Terakhir</h5>
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
            <div class="col-xl-6 d-flex col-xs-12">
                <div class="card flex-fill">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Terakhir Laporan</h5>
                    </div>
                    <table id="tabel" class="table table-responsive table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
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
                                <td class="alert-success" nowrap><li class="fas fa-arrow-circle-down alert-success"> </li><b>{{' '.$pendapatan}}</b></span></td>
                                <td class="alert-danger" nowrap><li class="fas fa-arrow-circle-up alert-danger"> </li><b>{{' '.$kasbon}}</b></td>
                                <td class="alert-info" nowrap><b>{{$total}}</b></td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Seslisih dari Sebelumnya</h5>
                        <?php if($pendapatan_terakhir == null): ?>
                        <h3 class="mt-1 mb-3 text-info"><li class="fas fa-arrow-circle-down"></li> 0</h3>
                        <?php else: ?>
                        <?php $pendapatan_tera = ''.number_format($pendapatan_terakhir->total,0,'','.'); ?>
                        <h3 class="mt-1 mb-3 text-info"><li class="fas fa-arrow-circle-down"></li> {{$pendapatan_tera}}</h3>
                        <?php endif; ?>
                        <div class="mb-1">
                            <?php if($pendapatan_terakhir == null): ?>
                            <span class="text-muted">kosong</span>
                            <?php else: ?>
                            <span class="text-muted">{{$pendapatan_terakhir->tgl}}</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div> --}}
        </div>

    </div>
</main>
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
    } );
    
</script>
@endsection