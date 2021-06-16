@extends('layout/main')

@section('title','Informasi')
@section('main')
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Informasi</h1>

        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="alert alert-primary alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <div class="alert-message">
                                <strong>Informasi</strong> Kepada Seluruh Karyawan Divisi Ekonomi
                            </div>
                        </div>
                        <h2 class="mb-0">Judul Informasi</h2>
                        <h6 class="card-title mb-0">Tanggal</h6>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
@section('script')

@endsection