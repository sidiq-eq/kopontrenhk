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
							@if (session('status'))
								<div class="alert {{session('alert-class')}} alert-dismissible" role="alert" id="message">
									
									<div class="alert-message">
										<b>{{session('status')}}</b>
									</div>
								</div>
							@endif
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
									<small id="karyawan_status"></small>
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
											<button class="btn btn-info" id="loadingdiv" disabled style="display:none">
												<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
												<span class="sr-only">Loading...</span>
											</button>
										<label class="form-label">  |  Foto</label>
											<button type="button" id="upload" class="btn btn-success" data-toggle="modal" data-target="#camera"><li class="fas fa-camera"></li> Kamera</button>
											<button class="btn btn-success" id="loadingdiv" type="button" style="display: none">
												<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
												<span class="sr-only">Loading...</span>
											</button>
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
								<button type="submit" class="spinner-button btn btn-lg btn-block btn-primary" id="submit" onclick="submit()"><span class="fas fa-sign-in-alt"></span> Submit</button>
							
								
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
	if(
		(("standalone" in window.navigator)&& !window.navigator.standalone)
		||
		(!window.matchMedia('(display-mode : standalone)').matches)
	){
		addToHomescreen({ skipFirstVisit: true, startDelay: 15, });
		//window.addToHomescreen();
	}
</script>

<script>
	 setTimeout(function() {
        $('#message').fadeTo(500, 0).slideUp(500, function(){
                    
        $(this).remove(); 
        });
    }, 6000);
	var x = document.getElementById("demo");
	function getLocation() {
	    $("#loadingdiv").css("display","inline");
	if (navigator.geolocation) {
	    
		navigator.geolocation.getCurrentPosition(showPosition);
	} else {
		x.innerHTML = "Geolocation is not supported by this browser.";
	}
	}

	// $('#nama').change(function() {
    //     var id = $(this).find(':selected')[0].id;
    //     alert(id); 
    //     $.ajax({
    //         type:'POST',
    //         url:'../include/continent.php',
    //         data:{'id':id},
    //         success:function(data){
    //             // the next thing you want to do 
			
	// 			}
	// 		}
    //     });

    // });

	function showPosition(position) {
		$("#loadingdiv").css("display","none");
		x.innerHTML = "<span class='fas fa-check-circle alert-success'></span> Lokasi Berhasil Terdeteksi &nbsp;&nbsp;"
		var img_url = "https://maps.google.com/?q="+position.coords.latitude+","+position.coords.longitude+"";
		//console.log(img_url);
		
		document.getElementById('lokasi').setAttribute("disabled",'');
		
		document.getElementById('loc').setAttribute("value",img_url);
	}
	
	function submit(){
	    jQuery('#activity_pane').showLoading();
	}
	
	$(document).ready(function(){
	    $('#nama').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
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
        	var nama_pendek = TextAbstract(nama,15);
            $('#amanahid').val(amanah);
            $('#id').val(id);
			$.ajax({
				type: 'post',
                url : '/get_status',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id':id
                    },
                dataType :'json',
				success:function(data){
					if(data>0){
						$('#inputKet').val('Pulang');
						$('#up').css('display','inline-block').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
						$('#down').css('display','none');
						
						//$("#inputKet").fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
						$('#inputKet').attr('readonly','readonly').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
						$('#karyawan_status').text(nama_pendek+', Anda sudah absen datang otomatis ket. jadi "Pulang"').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);;
					}
					else{
						$('#inputKet').val('Datang');
						$('#up').css('display','none');
						$('#down').css('display','inline-block').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
						//$("#inputKet").fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
						$('#inputKet').attr('readonly','readonly').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
						
						$('#karyawan_status').text(nama_pendek+', Anda belum absen datang otomatis ket. jadi "Datang"').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);;
					}
			
				}
			});

        });
	});

	function TextAbstract(text, length) {
		if (text == null) {
			return "";
		}
		if (text.length <= length) {
			return text;
		}
			text = text.substring(0, length);
			last = text.lastIndexOf(" ");
			text = text.substring(0, last);
			return text + "...";
	}
	function take_snapshot() {
			Webcam.snap( function(data_uri) {
							document.getElementById('demo').innerHTML += '<span class="fas fa-check-circle alert-success"></span>'+'Sukses! Upload Foto';
							document.getElementById('upload').setAttribute("disabled",'');
							document.getElementById('uri').setAttribute('value',data_uri);
							$('#demo').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
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