@extends('layout/mainsupervisor')

@section('title','Semua Data')
@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-xs-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4"> Nama Unit Usaha</h5>
                        <h3 class="mt-1 mb-3 text-secondary" ><i class="fas fa-business-time""></i>{{' '.$unit->nama_unit}}</h3>
                        <div class="mb-1">
                            <span class="text-muted">ID Unit : {{$unit->id_unit}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Status Laporan hari ini</h5>
                        <?php if($status == 0) :?>
                        <h3 class="mt-1 mb-3 text-danger"><li class="fas fa-times-circle"></li> Belum Laporan</h3>
                        <?php else : ?>
                        <h3 class="mt-1 mb-3 text-success"><li class="fas fa-check-circle"></li> Sudah Laporan</h3>
                        <?php endif; ?>
                        <div class="mb-1">
                            <span class="text-muted">Status saat ini</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
                        <span class="text-muted">Ringkasan Pendapatan Bulan : </span>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="h3 mb-3">Grafik Pendapatan</h1>
        <div class="row">
            <div class="col-12">
                
                    <div class="card flex-fill w-100">
                        <div class="card-header">
    
                            <h5 class="card-title mb-0">Pendapatan {{$jumlah}} (Bulan : {{date('F')}})</h5>
                            <a href="{{ url('semua-data/'.$unit->id_unit) }}"> <li class="fas fa-arrow-circle-right"></li>Grafik Bulan ini</a>
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
                        <h5 class="card-title">Berikut data pendapatan {{$unit->nama_unit}}</h5>
                        
                    </div>
                        <table id="tabel" class="table table-responsive table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                        <span class="text-muted">Ringkasan Konsinyasi Bulan : </span>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="h3 mb-3">Grafik Konsinyasi</h1>
        <div class="row">
            <div class="col-12">
                
                    <div class="card flex-fill w-100">
                        <div class="card-header">
    
                            <h5 class="card-title mb-0">Pendapatan {{$jumlah}} (Bulan : {{date('F')}})</h5>
                            <a href=""> <li class="fas fa-arrow-circle-right"></li>Grafik Bulan ini</a>
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

            <div class="col-xl-5 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        
                        <h5 class="card-title">Berikut data konsinyasi {{$unit->nama_unit}}</h5>
                        
                    </div>
                        <table id="tabel2" class="table table-responsive table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th class="alert-info"><center>Total</center></th>
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
            <div class="col-xl-7 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        
                        <h5 class="card-title">Berikut data Absen {{$unit->nama_unit}}</h5>
                        
                    </div>
                        <table id="tabel3" class="table table-responsive table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Waktu</th>
                                    <th>Jumlah Jam</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absen as $data)
                                

                                    <tr>
                                        <?php 
                                            $jumlah_jam = '00:00:00';
                                            //$jumlah_jam = date('H:i:s', $jumlah_jam);
                                            $tanggal = date('d/m',strtotime($data->tgl));
                                            $datang = strtotime($data->datang);
                                            $pulang= strtotime($data->pulang);
                                            // $datang = date('H:i:s',$datang);
                                            // $pulang = date('H:i:s',$pulang);
                                            
                                            $jumlah_jam= $pulang-$datang;
                                            $jumlah_jam = round(($jumlah_jam%86400)/3600,2);
                                            //$jumlah_jam = floor(($jumlah_jam%86400)/3600);
                                        ?>
                                            <td>{{$tanggal}}</td>
                                            <td><label for=""><b>{{$data->nama}}</b></label>
                                                </td>
                                            <td><li class="fas fa-arrow-circle-down alert-success"></li>
                                                {{$data->datang.' '}}<li class="fas fa-arrow-circle-up alert-danger"></li>{{' '.$data->pulang}}</td>
                                            
                                                <?php if($data->pulang=='00:00:00') {?>
                                                    <td>Tidak Diketahui</td>
                                                <?php }else { ?>
                                                    <td>{{$jumlah_jam}}</td>
                                                <?php } ?>
                                                <td>
                                                    <button data-toggle="modal" data-target="#detail" data-tgl="{{$data->tgl}}" data-id="{{$data->id_karyawan}}" onclick="detail('{{$data->tgl}}','{{$data->id_karyawan}}')" class="btn btn-outline-info btn-sm">detail</button>
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

<div class="modal" id="detail" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail absen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
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
                <tbody id="table_detail">
                    
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
<script>

    
        
    function detail(tgl,id){
        console.log(tgl);
        console.log(id);

        $.ajax({
                type: 'post',
                url : '/get_detail',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'tgl':tgl,
                    'id':id
                    },
                dataType :'json',
                success : function(data){
                    
                        var baris = '';
                        for(var i = 0 ; i < data.length; i++){
                            if(data[i].ket=='Datang'){
                            baris += '<tr class="table-success">'+
                                    '<td>'+data[i].nama+'</td>'+
                                    '<td>'+data[i].waktu+'</td>'+
                                    '<td>'+data[i].tgl+'</td>'+
                                    '<td><center><li class="fas fa-arrow-circle-down alert-success"></li>'+data[i].ket+'<small> <a href="'+data[i].lokasi+'"><li class="fas fa-map-marker-alt"></li>  Cek</a></small></center></td>'+
                                    '<td><center><a href="{{url("/asset/images/")}}/'+data[i].foto+'" class="btn btn-sm btn-primary"><li class="fa fa-play"></li></a></center></td>'+
                            '</tr>';
                            }else{
                                baris += '<tr class="table-danger">'+
                                    '<td>'+data[i].nama+'</td>'+
                                    '<td>'+data[i].waktu+'</td>'+
                                    '<td>'+data[i].tgl+'</td>'+
                                    '<td><center><li class="fas fa-arrow-circle-up alert-danger"></li>'+data[i].ket+'<small> <a href="'+data[i].lokasi+'"><li class="fas fa-map-marker-alt"></li>  Cek</a></small></center></td>'+
                                    '<td><center><a href="{{url("/asset/images/")}}/'+data[i].foto+'" class="btn btn-sm btn-primary"><li class="fa fa-play"></li></a></center></td>'+
                            '</tr>';
                            }
                        }
                        $('#table_detail').html(baris);
                   
                    
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
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
            "sScrollX": '100%',
            "dom": '<"top"l>rt<"bottom"fp><"clear">',
        } );
        $('#tabel2').DataTable( {
            "sScrollX": '100%',
            "dom": '<"top"l>rt<"bottom"fp><"clear">',
        } );
        $('#tabel3').DataTable( {
            "sScrollX": '100%',
            "dom": '<"top"l>rt<"bottom"fp><"clear">',
        } );
    } );
    setTimeout(function() {
        $('#message').fadeTo(500, 0).slideUp(500, function(){
                    
        $(this).remove(); 
        });
    }, 6000);
</script>

@endsection