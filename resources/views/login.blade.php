@extends('layout/main')

@section('title',$title)
@section('main')

	<main class="content">
		<div class="container-fluid p-0">

			<center>
				<h1 class="h3 mb-3">Login ke Aplikasi</h1>
			</center>

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
							<h6 class="card-subtitle text-muted">Silahkan masuk ke System</h6>
						</div>
						<div class="card-body">
							<form action="/auth-login" method="post">
								@csrf
								<div class="mb-3">
									<label class="form-label">Username</label>
									<input type="text" name="username" class="form-control" placeholder="" required>
								</div>
								<div class="mb-3">
									<label class="form-label">Password</label>
									<input type="password" name="password" class="form-control" placeholder="" required>
								</div>
								
								<button type="submit" class="btn btn-lg btn-block btn-primary"><span class="fas fa-sign-in-alt"></span> Login</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

@endsection
@section('script')
<script>
	setTimeout(function() {
        $('#message').fadeTo(500, 0).slideUp(500, function(){
                    
        $(this).remove(); 
        });
    }, 6000);
</script>
@endsection