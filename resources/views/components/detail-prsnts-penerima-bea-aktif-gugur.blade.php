<table class="table table-bordered">
    <thead>
        <tr>
            <th class="bg-primary-subtle text-center">
                NIM
            </th>
            <th class="bg-primary-subtle text-center">
                Nama
            </th>
            <th class="bg-primary-subtle text-center">
                Status
            </th>
            <th class="bg-primary-subtle text-center">
                Beasiswa
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($semuaPenerima as $penerima)
            <tr>
                <td>{{ $penerima->mhs_nim }}</td>
                <td>{{ $penerima->mahasiswa->nama ?? null }}</td>
                <td>
                    @if ($penerima->status == \App\Models\KesimpulanBeasiswa::LOLOS)
                        <span class="badge bg-green">Lolos</span>
                    @elseif ($penerima->status == \App\Models\KesimpulanBeasiswa::TIDAK_LOLOS)
                        <span class="badge bg-danger-lt">Tidak Lolos</span>
                    @endif
                </td>
                <td>{{ $penerima->jenis_beasiswa_pmb->keterangan ?? null }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
