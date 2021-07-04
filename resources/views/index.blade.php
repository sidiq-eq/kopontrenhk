@extends('layout/main')
@section('head')
<script type="text/javascript" src="{{asset('asset/js/webcam.min.js')}}"></script>
@endsection
@section('title','Absen Kopontren HK')
@section('main')
	<main class="content">
		<div class="container-fluid p-0">

			<div class="row">
				<h1 class="h3 mb-3">Form Absen</h1>
			</div>

			<div class="row">
				<div class="col-12 col-xl-6">
					<div class="card">
						<div class="card-header">
							<h6 class="card-subtitle text-muted">Silahkan absen sesuai nama</h6>
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
							<form action="/submit" method="post">
								@csrf
								<div class="mb-3">
									<label class="form-label" for="inputState">Nama</label>
									<input type="hidden" id="id" name="id" value="">
									<select id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" >
										<option selected disabled>Pilih Nama Anda</option>
										<?php foreach ($data as $karyawan) : ?>
											@if (old('nama')==$karyawan->nama)
											<option data-nama='<?= $karyawan->nama ?>' data-id='<?= $karyawan->id_karyawan ?>' data-amanah='<?= $karyawan->nama_amanah.' '.$karyawan->nama_unit ?>' value="<?= $karyawan->nama ?>" selected><?= $karyawan->nama ?></option>
												
											@else
												
											<option data-nama='<?= $karyawan->nama ?>' data-id='<?= $karyawan->id_karyawan ?>' data-amanah='<?= $karyawan->nama_amanah.' '.$karyawan->nama_unit ?>' value="<?= $karyawan->nama ?>"><?= $karyawan->nama ?></option>
											@endif
										<?php endforeach; ?>
									</select>
									@error('nama')
									<div class="invalid-feedback">
										{{$message}}
									</div>
									@enderror
								</div>
								<div class="mb-3">
									<label class="form-label">Amanah</label>
									<input id="amanahid" name="amanah" type="text" class="form-control" value="{{old('amanah')}}" readonly required>
								</div>
								<div class="row">
									<div class="mb-3 col-4">
										<label class="form-label">Hari</label>
										<input type="text" class="form-control col-md-4" readonly value="<?= date('D');?>">
									</div>
									<div class="mb-3 col-4">
										<label class="form-label">Waktu</label>
										<input id="dates" name="waktu" type="text" class="form-control col-md-4" readonly value="">
									</div>
									<div class="mb-3 col-4">
										<label class="form-label">Tanggal</label>
										<input type="text" name="tgl" class="form-control col-md-4" readonly value="<?= date('d/m/Y');?>">
									</div>
								</div>
								<div class="row">
									<div class="mb-3 col-10">
										<label class="form-label" for="inputState">Keterangan</label>
										
										<select id="inputKet" name="ket" class="form-control" aria-label="Default select example">
											<?php 
												$waktu = date('H:i:s');
												?>
												 <option class="alert success" value="Datang" <?php if($waktu>='00:00:00' && $waktu<='12:00:00') echo'selected'; ?>>Datang</option>
												 <option value="Pulang" <?php if($waktu>'12:00:00' && $waktu<='23:59:00') echo'selected'; ?>>Pulang</option>
												
											
										</select>
									</div>
									<div class="mb-3 col-2">
										<label class="form-label">Icon</label>
										<div>
											<?php 
												if ($waktu>='00:00:00' && $waktu<='12:00:00') {
													echo '<span id="up" style="font-size: 30px; color: red; display :none" class="fas fa-arrow-circle-up"></span><span id="down" style="font-size: 30px; color: green; display :inline-block" class="fas fa-arrow-circle-down"></span>';
												} elseif ($waktu>'12:00:00' && $waktu<='23:59:00') {
													echo '<span id="up" style="font-size: 30px; color: red; display :inline-block" class="fas fa-arrow-circle-up"></span><span id="down" style="font-size: 30px; color: green; display :none" class="fas fa-arrow-circle-down"></span>';
												}
												
												?>
											
											

										</div>
									</div>
								</div>
								<div class="mb-1">
									<center>

										<label class="form-label">Lokasi</label>
											<button type="button" id="lokasi" class="btn btn-info" onclick="getLocation()"><li class="fas fa-map-marker-alt"></li> Lokasi</button>
										<label class="form-label">  |  Foto</label>
											<button type="button" id="upload" class="btn btn-success" data-toggle="modal" data-target="#camera"><li class="fas fa-camera"></li> Kamera</button>
										@error('foto')
											<small>harap upload foto</small>
											
										@enderror
										<small id="status"></small>
									</center>
								</div>
								<div>
									<center>
										<small id="demo"></small>
										<input type="hidden" id="loc" name="lokasi" value="">
									</center>
								</div>
								<input type="hidden" id="uri" value="" name="foto">
								<button type="submit" class="btn btn-lg btn-block btn-primary"><span class="fas fa-sign-in-alt"></span> Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

@endsection
@section('modal')
<div class="modal fade" id="camera" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ambil Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <div id="my_camera"></div>
            </div>
            <div class="modal-footer">


					<button type="button" class="btn btn-block btn-primary btn-lg" data-dismiss="modal" aria-label="Close" onclick="take_snapshot()">Ambil Foto</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>

	var x = document.getElementById("demo");
	function getLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showPosition);
	} else {
		x.innerHTML = "Geolocation is not supported by this browser.";
	}
	}

	function showPosition(position) {
		x.innerHTML = "Latitude: " + position.coords.latitude +
		"<br>Longitude: " + position.coords.longitude;
		var img_url = "https://maps.google.com/?q="+position.coords.latitude+","+position.coords.longitude+"";
		console.log(img_url);

		document.getElementById('lokasi').setAttribute("disabled",'');
		document.getElementById('loc').setAttribute("value",img_url);
	}
	$(document).ready(function(){
		Webcam.set( 'constraints',{ facingMode:'front' });
		Webcam.set({
		width: 220,
		height: 330,
		
		image_format: 'jpg',
		jpeg_quality: 90
		});

		Webcam.attach( '#my_camera' );
		
		$("#inputKet").change(function(){
			var input = $(this).children("option:selected").val();
			if(input=='Datang'){
				$('#up').css('display','none');
				$('#down').css('display','inline-block');
			}else{
				$('#up').css('display','inline-block');
				$('#down').css('display','none');
			}
		});
		$('#nama').change(function(){
            amanah=$('#nama option:selected').data('amanah');
            id=$('#nama option:selected').data('id');
            nama=$('#nama').val();
            console.log(nama);
            console.log(amanah);
            $('#amanahid').val(amanah);
            $('#id').val(id);
        });
	});

	function take_snapshot() {
			Webcam.snap( function(data_uri) {
							document.getElementById('status').innerHTML = '<li class="fa fa-check"></li>'+'Sukses! Upload Foto';
							document.getElementById('upload').setAttribute("disabled",'');
							document.getElementById('uri').setAttribute('value',data_uri)
			} );
			
		}
	function doDate()
		{
			var str = "";

			var days = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
			var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

			var now = new Date();
			var jam = now.getHours();
			var menit = now.getMinutes();
			var detik = now.getSeconds();

			$('#dates').val(jam+':'+menit+':'+detik);
		}

	setInterval(doDate, 1000);
	</script>
@endsection