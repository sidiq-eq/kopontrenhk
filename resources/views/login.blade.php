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
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <div class="alert-message">
                                    <b>{{session('status')}}</b>
                                </div>
                            </div>
                        @endif
							<h6 class="card-subtitle text-muted">Hanya Admin yang bisa masuk</h6>
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

@endsection