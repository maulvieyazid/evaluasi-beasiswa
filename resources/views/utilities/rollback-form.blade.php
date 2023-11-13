<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rollback Penerima Beasiswa</title>
</head>

<body>
    @php
        use App\Models\KesimpulanBeasiswa;
    @endphp
    <h3>Apakah anda yakin ingin merollback data penerima beasiswa ini</h3>

    <ul>
        <li>
            NIM : {{ $penerima->mhs_nim }}
        </li>
        <li>
            Nama : {{ $penerima->mahasiswa->nama }}
        </li>
        <li>
            Beasiswa : {{ $penerima->jenis_beasiswa_pmb->nama }}
        </li>
        <li>
            Semester : {{ $penerima->smt }}
        </li>
        <li>
            Status : {{ $penerima->status == KesimpulanBeasiswa::LOLOS ? 'LOLOS' : 'TIDAK LOLOS' }}
        </li>
    </ul>

    @php
        $route = route('rollback-beasiswa', [
            'nim' => $penerima->mhs_nim,
            'kd_jns_bea_pmb' => $penerima->jns_beasiswa,
            'smt' => $penerima->smt,
        ]);
    @endphp
    <form action="{{ $route }}" method="POST" id="form">
        @csrf
        <button type="button" onclick="rollback()" id="btnRollback">
            Iya, rollback
        </button>
    </form>

    <script>
        function rollback() {
            let lanjut = confirm('Anda benar-benar yakin? Data syarat peserta dan kesimpulan beasiswa dari penerima beasiswa tsb akan hilang.')

            if (!lanjut) return;

            document.getElementById('form').submit();
        }
    </script>

</body>

</html>
