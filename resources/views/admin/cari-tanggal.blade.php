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
                        <h5 class="card-title">Berikut data absen</h5>
                        <h6 class="card-subtitle text-muted">dengan parameter Tanggal : {{$tgl}} bulan : {{$bulan}} tahun : {{$tahun}} </h6>
                    </div>
                    <div class="row">
                        <div class="container">
                            <a class="btn btn-info btn-sm" href="{{url('/list_absen')}}"><i class="fa fa-arrow-left"></i> Back</a>
                                <button class="btn btn-primary btn-sm" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button>
                                <form action="/export-tanggal" method="post" style="display: inline">
                                    @csrf
                                    <input type="hidden" name="tgl" value="{{$tgl}}">
                                    <input type="hidden" name="bulan" value="{{$bulan}}">
                                    <input type="hidden" name="tahun" value="{{$tahun}}">
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-file"></i> Excel</button>
                                </form>
                        </div>
                    </div>
                    <table id="tabel" class="table table-striped table-hover table-responsive">
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
                           
                            @foreach ($data_absen as $absen)
                                

                                    <tr>
                                        <?php 
                                            $jumlah_jam = '00:00:00';
                                            //$jumlah_jam = date('H:i:s', $jumlah_jam);
                                            $tanggal = date('d/m/Y',strtotime($absen->tgl));
                                            $datang = strtotime($absen->datang);
                                            $pulang= strtotime($absen->pulang);
                                            // $datang = date('H:i:s',$datang);
                                            // $pulang = date('H:i:s',$pulang);
                                            
                                            $jumlah_jam= $pulang-$datang;
                                            $jumlah_jam = round(($jumlah_jam%86400)/3600,2);
                                            //$jumlah_jam = floor(($jumlah_jam%86400)/3600);
                                        ?>
                                            <td>{{$tanggal}}</td>
                                            <td><label for=""><b>{{$absen->nama}}</b><small>{{' '.$absen->id_unit}}</small></label>
                                                </td>
                                            <td><li class="fas fa-arrow-circle-down alert-success"></li>
                                                {{$absen->datang.' '}}<li class="fas fa-arrow-circle-up alert-danger"></li>{{' '.$absen->pulang}}</td>
                                            
                                                <?php if($absen->pulang=='00:00:00') {?>
                                                    <td>Tidak Diketahui</td>
                                                <?php }else { ?>
                                                    <td>{{$jumlah_jam}}</td>
                                                <?php } ?>
                                                <td>
                                                    <button data-toggle="modal" data-target="#detail" data-tgl="{{$absen->tgl}}" data-id="{{$absen->id_karyawan}}" onclick="detail('{{$absen->tgl}}','{{$absen->id_karyawan}}')" class="btn btn-outline-info btn-sm">detail</button>
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
        // $('#detail').on('show.bs.modal', function(event){
        //     var detail = $(event.relatedTarget)
        //     var tgl = detail.data('tgl')
        //     var id = detail.data('id')
            
        //     console.log(id);
        //     var modal = $(this)
            
        // });

    function strtrunc(str, max, add){
        add = add || '...';
        return (typeof str === 'string' && str.length > max ? str.substring(0, max) + add : str);
    };

    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
    }
    $(document).ready(function() {
        $('#tabel').DataTable({
            columnDefs:[
                {visible:false,target:2}
            ],
            displayLength:25,
            lengthChange: false,

            drawCallback:function(settings){
                var api = this.api();
                var rows = api.rows({page:'current'}).nodes();
                var last=null;

                api.column(0, {page:'current'}).data().each(function(group,i){
                    if(last !== group){
                        $(rows).eq(i).before(
                            '<tr class="text-primary"><td colspan=5><b><li class="fas fa-arrow-right"></li> '+group+'</b></td></tr>'
                        );
                        last = group;
                    }
                });
            }

            
        })
    } );
</script>

@endsection