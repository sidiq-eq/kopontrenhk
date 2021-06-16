@extends('layout/mainadmin')

@section('title','Cek Absensi')
@section('main')
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Cek Absen</h1>

        <div class="row">

            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Cek Absen hari Ini Tanggal : <?= date('d/F/y') ?></h5>
                        <h6 class="card-subtitle text-muted">Anda bisa cek semua absensi yang masuk</h6>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Waktu</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="img/avatars/avatar-5.jpg" width="48" height="48" class="rounded-circle mr-2" alt="Avatar"> Vanessa Tucker
                                </td>
                                <td>864-348-0485</td>
                                <td>June 21, 1961</td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="img/avatars/avatar-2.jpg" width="48" height="48" class="rounded-circle mr-2" alt="Avatar"> William Harris
                                </td>
                                <td>914-939-2458</td>
                                <td>May 15, 1948</td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="img/avatars/avatar-3.jpg" width="48" height="48" class="rounded-circle mr-2" alt="Avatar"> Sharon Lessman
                                </td>
                                <td>704-993-5435</td>
                                <td>September 14, 1965</td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="img/avatars/avatar-4.jpg" width="48" height="48" class="rounded-circle mr-2" alt="Avatar"> Christina Mason
                                </td>
                                <td>765-382-8195</td>
                                <td>April 2, 1971</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            
            
        </div>

    </div>
</main>
@endsection
@section('script')

@endsection