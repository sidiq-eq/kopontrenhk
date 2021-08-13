@extends('layout/mainsupervisor')

@section('title','Karyawan')
@section('main')
<main class="content">
    <div class="container-fluid p-0 " id="printableArea">

        <h1 class="h3 mb-3">Data Karyawan</h1>

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
                        <h5 class="card-title">Berikut data karyawan kopontren HK</h5>
                        <a class="btn btn-info btn-sm" href="{{url('/cek-data')}}"><i class="fa fa-arrow-left"></i> Back</a>
                                <button class="btn btn-primary btn-sm" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button>
                    </div>
                    <table id="tabel" class="table table-responsive table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Unit & Amanah</th>
                                <th>Masa Kerja</th>
                                <th>No HP</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data_karyawan as $karyawan)
                            <?php 
                            $tgl = date('Ymd');

                            $ts1 = strtotime($karyawan->masuk);
                            $ts2 = strtotime($tgl);

                            $year1 = date('Y', $ts1);
                            $year2 = date('Y', $ts2);

                            $month1 = date('m', $ts1);
                            $month2 = date('m', $ts2);

                            $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                            ?>    
                            
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$karyawan->nama}}
                                </td>
                                <td>{{$karyawan->nama_unit.' ('.$karyawan->nama_amanah.')'}}</td>
                                <td>{{$karyawan->masuk.' ('.$diff.' Bulan)'}}</td>
                                <td>{{$karyawan->no_hp}}</td>
                                
                                
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
    setTimeout(function() {
        $('#message').fadeTo(500, 0).slideUp(500, function(){
                    
        $(this).remove(); 
        });
    }, 6000);
</script>

@endsection