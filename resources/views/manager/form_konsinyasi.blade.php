@extends('layout/mainmanager')

@section('title','Form Input Konsinyasi')
@section('main')
	<main class="content">
		<div class="container-fluid p-0">

			<div class="row">
				<h1 class="h3 mb-3">From Input Konsinyasi</h1>
			</div>

			<div class="row">
				<div class="col-12 col-xl-6">
					<div class="card">
						<div class="card-header" style="padding-bottom: 0px">
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
							<h6 class="card-subtitle text-muted">Input Konsinyasi per hari</h6>
							<a href="{{url('form-pendapatan')}}"> >>Input Pendapatan disini</a>

							<p><li class="fa fa-info-circle"></li> Masukan Total Laba Konsinyasi Unit Per hari, Jika Unit tidak ada konsinyasi abaikan form ini</p>
						</div>
						<div class="card-body">
							@if($errors->any())
								@foreach ($errors->all() as $error)
									<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
										<div class="alert-message">
											{{$error}}
										</div>
									</div>
								@endforeach
							@endif
							<form action="/tambah-konsinyasi" method="post">
								@csrf
								<div class="mb-3">
									<label class="form-label" for="inputState">Nama Unit Usaha</label>
									<select  class="form-control" disabled>
										<?php foreach ($unit as $item) : ?>
											<option value="<?= $item->id_unit ?>"><?= $item->nama_unit ?></option>
											<input type="hidden" name="unit" value="<?= $item->id_unit ?>">
										<?php endforeach; ?>
									</select>
								</div>
								<div class="mb-3">
									<label class="form-label">Tanggal</label>
									<input type="date" id="txtDate" name="tgl" class="form-control" required>
									<small>Masukan Tanggal Laporan (otomatis set tanggal hari ini)</small>
								</div>
								<label class="form-label">Total</label>
                                <div class="mb-3 input-group">
									<span class="input-group-text alert-success" id="basic-addon1"><li class="fas fa-arrow-circle-down alert-success"></li>&nbsp;Rp.</span>
									<input type="text" id="total" class="form-control alert-success input_key"  aria-describedby="basic-addon3" value="0">
									<input type="hidden" id="total_hidden" name="total" value="">
								</div>
								
                                
								<button type="button" class="btn btn-lg btn-block btn-primary" id="submit" onclick="confirm()"><span class="fas fa-sign-in-alt"></span> Submit</button>
								<div class="row" id="label" style="display: none">
									<div class="col">
										<label for=""><li class="fas fa-question-circle"></li> Apakah Anda Sudah Yakin?</label>
									</div>
								</div>
								<div class="row" id="button" style="display: none">
									<div class="col-6">
										<button type="submit" class="btn btn-block btn-lg btn-success"><span class="fas fa-check-circle"></span> Yakin</button>
									</div>
									<div class="col-6">
										<button type="button" class="btn btn-block btn-lg btn-danger" onclick="cancel()"><span class="fas fa-times-circle"></span> Tidak</button>
									</div>
								</div>
							
								
							</form>
							
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

	
	$(function(){
		var dtToday = new Date();

		var month = dtToday.getMonth() + 1;
		var day = dtToday.getDate();
		var year = dtToday.getFullYear();

		if(month < 10)
			month = '0' + month.toString();
		if(day < 10)
			day = '0' + day.toString();

		var maxDate = year + '-' + month + '-' + day;    
		$('#txtDate').attr('max', maxDate);
		document.getElementById("txtDate").value = year+'-'+month+'-'+day;
	});
	$('#total').on('click touchend',function(e){
		if($('#total_hidden').val()>=0 && $('#total_hidden').val()<=99){
			$('#total').val('');
		}else{
			
		}
	});
	

	// function hitung(){
	// 	var totalid = document.getElementById("total");
	// 	var kasbon = $('[name=kasbon]').val();
	// 	var pendapatan = $('[name=pendapatan]').val();
	// 	// console.log(pendapatan+' '+kasbon);
	// 	var pendapatan_new = pendapatan.replace(/\./g,'');
	// 	var kasbon_new = kasbon.replace(/\./g,'');
	// 	// console.log(pendapatan_new+' - '+kasbon_new);
	// 	var total = pendapatan_new-kasbon_new;
	// 	$('[name=total]').val(total);
	// 	var total_curr = total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
	// 	// console.log(total_curr);
	// 	totalid.innerHTML = 'Rp. '+total_curr;
	// }
	function confirm(){
		
		$("#submit").animate({opacity: "0"}).slideUp(500, function(){
			$(this).css('visibility','hidden'); 
		});
        $("#label").attr("style","").animate({opacity: "1"});
        $("#button").attr("style","");
	}
	function cancel(){
		$("#submit").animate({opacity: "1"}).slideDown(500, function(){
			$(this).css('visibility','visible'); 
		});
		$("#label").css("display","none").animate({opacity: "0"});
        $("#button").css("display","none").animate({opacity: "0"});
	}
	var total = document.getElementById("total");
	total.addEventListener("keyup", function(e) {
		var hide = document.getElementById("total_hidden");
		var total = document.getElementById("total");
		total.value = formatRupiah(this.value,'Rp. ');
		hide.value = total.value;
		// var value = hide.value;
		// //console.log(value);
		// total.innerHTML= 'Rp. '+value;
	});
	// $('.input_key').on('keypress',function(e) {
		
	// 	var totalid = document.getElementById("total");
	// 	var kasbon = $('[name=kasbon]').val();
	// 	var pendapatan = $('[name=pendapatan]').val();
	// 	// console.log(pendapatan+' '+kasbon);
	// 	var pendapatan_new = pendapatan.replace(/\./g,'');
	// 	var kasbon_new = kasbon.replace(/\./g,'');
	// 	console.log(pendapatan_new+' - '+kasbon_new);
	// 	var total = pendapatan_new-kasbon_new;
	// 	//console.log(total);
	// 	totalid.innerHTML = 'Rp. '+total;
	// });
	
	function formatRupiah(angka, prefix) {
	var number_string = angka.replace(/[^,\d]/g, "").toString(),
		split = number_string.split(","),
		sisa = split[0].length % 3,
		rupiah = split[0].substr(0, sisa),
		ribuan = split[0].substr(sisa).match(/\d{3}/gi);

	if (ribuan) {
		separator = sisa ? "." : "";
		rupiah += separator + ribuan.join(".");
	}

	rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
	return prefix == undefined ? rupiah : rupiah ? "" + rupiah : "";
	}

	setTimeout(function() {
        $('#message').fadeTo(500, 0).slideUp(500, function(){
                    
        $(this).remove(); 
        });
    }, 6000);

</script>
@endsection