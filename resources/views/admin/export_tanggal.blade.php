<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Amanah</th>
            <th>Waktu</th>
            <th>Jumlah Jam</th>
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
                        <td><label for=""><b>{{$absen->nama}}</b></label>
                            </td>
                        <td>{{$absen->nama_amanah.' '.$absen->id_unit}}</td>
                        <td>
                            {{$absen->datang.' | '.$absen->pulang}}
                        </td>
                        
                            <?php if($absen->pulang=='00:00:00') {?>
                                <td>Tidak Diketahui</td>
                            <?php }else { ?>
                                <td>{{$jumlah_jam}}</td>
                            <?php } ?>
                </tr>
        @endforeach
    </tbody>
</table>