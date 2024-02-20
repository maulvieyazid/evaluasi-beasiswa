@extends('layouts.app', ['navbar' => 'master-syarat'])

@section('html_title', 'Maintenance Syarat Beasiswa')

@php
    use App\Models\SyaratBeasiswa;
    use App\Models\Departemen;
    use Illuminate\Support\Facades\Crypt;
@endphp

@section('content')
    <div class="page-wrapper">

        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">

                @include('layouts.alert')

                <div class="row g-2 align-items-center">
                    <div class="col">
                        <a class="btn btn-secondary mb-3" href="{{ route('index.master-syarat-beasiswa') }}">
                            <svg class="icon icon-tabler icon-tabler-arrow-narrow-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l14 0"></path>
                                <path d="M5 12l4 4"></path>
                                <path d="M5 12l4 -4"></path>
                            </svg>
                            Kembali
                        </a>

                        <h2 class="page-title">
                            Maintenance Syarat Beasiswa
                        </h2>

                    </div>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Informasi Beasiswa</div>
                                <div class="mb-2">
                                    <svg class="icon icon-tabler icon-tabler-id" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                                        <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M15 8l2 0"></path>
                                        <path d="M15 12l2 0"></path>
                                        <path d="M7 16l10 0"></path>
                                    </svg>
                                    <span class="ms-2">Kode</span> : <strong>{{ $beasiswa->kd_jenis }}</strong>
                                </div>
                                <div class="mb-2">
                                    <svg class="icon icon-tabler icon-tabler-id-badge-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 12h3v4h-3z"></path>
                                        <path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6"></path>
                                        <path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
                                        <path d="M14 16h2"></path>
                                        <path d="M14 12h4"></path>
                                    </svg>
                                    <span class="ms-2">Nama</span> : <strong>{{ $beasiswa->nama }}</strong>
                                </div>
                                <div class="mb-2">
                                    <svg class="icon icon-tabler icon-tabler-file-description" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M9 17h6" />
                                        <path d="M9 13h6" />
                                    </svg>
                                    <span class="ms-2">Keterangan</span> : <strong>{{ $beasiswa->keterangan }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col">
                        <div class="card">
                            <div class="table-responsive">
                                <input id="url_update" type="hidden" value="{{ route('update-json.master-syarat-beasiswa') }}">
                                <input id="url_store" type="hidden" value="{{ route('store-json.master-syarat-beasiswa') }}">
                                <input id="url_destroy" type="hidden" value="{{ route('destroy-json.master-syarat-beasiswa') }}">

                                <table class="table table-striped table-hover table-bordered" id="tabelSyarat">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-dark bg-primary-subtle">No</th>
                                            <th class="text-center text-dark bg-primary-subtle">Nama Syarat</th>
                                            <th class="text-center text-dark bg-primary-subtle w-0">Nilai Minimal</th>
                                            <th class="text-center text-dark bg-primary-subtle">Validator</th>
                                            <th class="text-center text-dark bg-primary-subtle">Otomatis Baca Nilai</th>
                                            <th class="text-center text-dark bg-primary-subtle">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($semuaSyarat as $syrt)
                                            <tr>
                                                <td class="text-center">
                                                    @php
                                                        $encSyarat = json_encode($syrt->only(['kd_syarat', 'jenis_beasiswa']));
                                                        $encSyarat = Crypt::encryptString($encSyarat);
                                                    @endphp
                                                    <input id="encSyarat" type="hidden" value="{{ $encSyarat }}">
                                                    {{ $loop->iteration }}.
                                                </td>

                                                <td>
                                                    <span class="nm_syarat" style="white-space: pre-line">{{ $syrt->nm_syarat }}</span>
                                                    <textarea class="form-control d-none nm_syarat" data-bs-toggle="autosize" data-default="{{ $syrt->nm_syarat }}">{{ $syrt->nm_syarat }}</textarea>
                                                </td>

                                                <td class="text-center">
                                                    <span class="nil_min">{{ $syrt->nil_min }}</span>
                                                    <input class="form-control d-none nil_min" data-default="{{ $syrt->nil_min }}" type="number" value="{{ $syrt->nil_min }}" min="1">
                                                </td>

                                                <td>
                                                    <span class="bagian_validasi">
                                                        {{ ucwords(strtolower($syrt->departemen->nama)) ?? null }}
                                                    </span>

                                                    <select class="form-select d-none bagian_validasi" data-default="{{ $syrt->bagian_validasi }}">
                                                        <option value="{{ Departemen::KMHS }}" {{ $syrt->bagian_validasi == Departemen::KMHS ? 'selected' : '' }}>
                                                            Kemahasiswaan
                                                        </option>
                                                        <option value="{{ Departemen::AAK }}" {{ $syrt->bagian_validasi == Departemen::AAK ? 'selected' : '' }}>
                                                            AAK
                                                        </option>
                                                        <option value="{{ Departemen::KEUANGAN }}" {{ $syrt->bagian_validasi == Departemen::KEUANGAN ? 'selected' : '' }}>
                                                            Keuangan
                                                        </option>
                                                    </select>
                                                </td>

                                                @php
                                                    $baca_nilai = '-';
                                                    $baca_nilai = $syrt->baca_nilai == SyaratBeasiswa::IPS ? 'IPS' : $baca_nilai;
                                                    $baca_nilai = $syrt->baca_nilai == SyaratBeasiswa::STSKULIAH ? 'Status Kuliah' : $baca_nilai;
                                                @endphp
                                                <td class="text-center">
                                                    <span class="baca_nilai">
                                                        {{ $baca_nilai }}
                                                    </span>

                                                    <select class="form-select d-none baca_nilai" data-default="{{ $syrt->baca_nilai }}">
                                                        <option value="" selected>-</option>
                                                        <option value="{{ SyaratBeasiswa::IPS }}" {{ $syrt->baca_nilai == SyaratBeasiswa::IPS ? 'selected' : '' }}>
                                                            IPS
                                                        </option>
                                                        <option value="{{ SyaratBeasiswa::STSKULIAH }}" {{ $syrt->baca_nilai == SyaratBeasiswa::STSKULIAH ? 'selected' : '' }}>
                                                            Status Kuliah
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="btnAksi">
                                                        <button class="btn btn-sm btn-outline w-100" type="button" onclick="edit(this)">
                                                            <svg class="icon icon-tabler icon-tabler-edit" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                                <path d="M16 5l3 3"></path>
                                                            </svg>
                                                            Ubah
                                                        </button>
                                                        <!-- Btn hapus hanya ditampilkan jika syarat tidak terikat dengan data syarat_peserta -->
                                                        @if (!$syrt->terikat_syarat_peserta)
                                                            <button class="btn btn-sm btn-danger w-100 mt-2" type="button" onclick="deleteSyrt(this)">
                                                                <svg class="icon icon-tabler icon-tabler-trash" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                                Hapus
                                                            </button>
                                                        @endif
                                                    </div>

                                                    <div class="d-none btnAksi">
                                                        <button class="btn btn-success btn-sm w-100" type="button" onclick="update(this)">
                                                            <svg class="icon icon-tabler icon-tabler-device-floppy" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                                                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                <path d="M14 4l0 4l-6 0l0 -4" />
                                                            </svg>
                                                            Simpan
                                                        </button>
                                                        <button class="btn btn-secondary btn-sm w-100 mt-2" type="button" onclick="cancel(this)">
                                                            <svg class="icon icon-tabler icon-tabler-x" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M18 6l-12 12" />
                                                                <path d="M6 6l12 12" />
                                                            </svg>
                                                            Batal
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col text-center">
                        <button class="btn btn-primary" type="button" onclick="add()">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Tambah Syarat
                        </button>
                    </div>
                </div>



            </div>
        </div>


        <template id="templateTabelSyarat">
            <tr>
                <td class="text-center">
                    @php
                        $encSyarat = json_encode($beasiswa->only(['kd_jenis']));
                        $encSyarat = Crypt::encryptString($encSyarat);
                    @endphp
                    <input id="encSyarat" type="hidden" value="{{ $encSyarat }}">
                    <span class="no"></span>
                </td>

                <td>
                    <span class="nm_syarat d-none" style="white-space: pre-line"></span>
                    <textarea class="form-control nm_syarat" data-bs-toggle="autosize"></textarea>
                </td>

                <td class="text-center">
                    <span class="nil_min d-none"></span>
                    <input class="form-control nil_min" type="number" value="1" min="1">
                </td>

                <td>
                    <span class="d-none bagian_validasi"></span>

                    <select class="form-select bagian_validasi">
                        <option value="{{ Departemen::KMHS }}" selected>
                            Kemahasiswaan
                        </option>
                        <option value="{{ Departemen::AAK }}">
                            AAK
                        </option>
                        <option value="{{ Departemen::KEUANGAN }}">
                            Keuangan
                        </option>
                    </select>
                </td>

                <td class="text-center">
                    <span class="d-none baca_nilai"></span>

                    <select class="form-select baca_nilai">
                        <option value="" selected>-</option>
                        <option value="{{ SyaratBeasiswa::IPS }}">
                            IPS
                        </option>
                        <option value="{{ SyaratBeasiswa::STSKULIAH }}">
                            Status Kuliah
                        </option>
                    </select>
                </td>
                <td>
                    <div class="btnAksi d-none">
                        <button class="btn btn-sm btn-outline w-100" type="button" onclick="edit(this)">
                            <svg class="icon icon-tabler icon-tabler-edit" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                <path d="M16 5l3 3"></path>
                            </svg>
                            Ubah
                        </button>
                        <button class="btn btn-sm btn-danger w-100 mt-2" type="button" onclick="deleteSyrt(this)">
                            <svg class="icon icon-tabler icon-tabler-trash" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                            Hapus
                        </button>
                    </div>

                    <div class="btnAksi">
                        <button class="btn btn-success btn-sm w-100" type="button" onclick="save(this)">
                            <svg class="icon icon-tabler icon-tabler-device-floppy" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M14 4l0 4l-6 0l0 -4" />
                            </svg>
                            Simpan
                        </button>
                        <button class="btn btn-danger btn-sm w-100 mt-2" type="button" onclick="cancelAdd(this)">
                            <svg class="icon icon-tabler icon-tabler-x" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18 6l-12 12" />
                                <path d="M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                    </div>
                </td>
            </tr>
        </template>


    </div>

@endsection

@push('js')
    <!-- Notiflix Notify -->
    <script src="{{ asset('assets/libs/notiflix/notiflix-notify-aio-3.2.6.min.js') }}"></script>

    <script>
        // Ini adalah kumpulan class dari elemen-elemen input dan span yang ada di tabel
        // Class ini harus sama dengan kolom tabel yang ada di database, supaya lebih mudah untuk melakukan manipulasi data
        const semuaClass = [
            'nm_syarat',
            'nil_min',
            'bagian_validasi',
            'baca_nilai',
        ];

        function edit(btn) {
            // Ambil tr dari button 'Ubah'
            const tr = $(btn).closest('tr');

            // Masuk Mode Edit
            toggleEditMode(tr);
        }

        function toggleEditMode(tr) {
            // Tambahkan titik di depan masing-masing nama class, lalu gabungkan dengan koma
            let clss = semuaClass.map(item => `.${item}`).join(',');

            // Lakukan toggle class d-none pada span dan input yang memilki class yang sama
            tr.find(clss).toggleClass('d-none');

            // Toggle juga btnAksi nya
            tr.find('.btnAksi').toggleClass('d-none');
        }

        function cancel(btn) {
            // Ambil tr dari button 'Batal'
            const tr = $(btn).closest('tr');

            // Keluar Mode Edit
            toggleEditMode(tr);

            // Lakukan reset pada inputan
            resetInput(tr);
        }

        function resetInput(tr) {
            // Ambil semua input
            const semuaInput = tr.find(':input');

            for (const clss of semuaClass) {
                // Ambil elemen input yang class nya sama dengan class yang dilooping
                const inputElm = semuaInput.filter(`.${clss}`);
                // Lalu ganti nilai nya dengan atribut 'data-default'
                inputElm.val(inputElm.data('default'));
            }
        }

        async function update(btn) {
            // Ubah button simpan menjadi object jquery
            const btnSimpan = $(btn);

            // Disable button Simpan dan Batal
            const btnAksiSimpanDanBatal = btnSimpan.closest('div').find('button');
            btnAksiSimpanDanBatal.prop('disabled', true);

            // Tambahkan loading pada button Simpan
            btnSimpan.addClass('btn-loading');

            /* =============================================== */
            /* Update Syarat Beasiswa */
            /* =============================================== */

            // Ambil tr dari button Simpan
            const tr = btnSimpan.closest('tr');

            // Ambil semua input yang ada di tr
            const semuaInput = tr.find(':input');

            // Buat satu object untuk menampung data request
            const reqData = {};
            // Lalu masukkan semua nilai input ke object tsb
            for (const clss of semuaClass) {
                reqData[clss] = semuaInput.filter(`.${clss}`).val();
            }

            // Masukkan juga nilai encSyarat ke object tsb
            reqData['encSyarat'] = tr.find('#encSyarat').val();

            // Ambil url dari input hidden
            let url = $('#url_update').val();

            try {
                const response = await axios.put(url, reqData);
                const data = await response.data;

                for (const clss of semuaClass) {
                    // Ambil input yang class nya sama dengan class yang di looping
                    const inputElm = semuaInput.filter(`.${clss}`);

                    // Set nilai input agar sesuai dengan syarat yang diupdate
                    inputElm.val(data.syarat[clss]);

                    // Kalau input nya bertipe textarea, maka set juga teks nya
                    if (inputElm.is('textarea')) inputElm.text(data.syarat[clss]);

                    // Set atribut data-default nya
                    inputElm.data('default', data.syarat[clss]);
                }

                // Samakan teks span dengan input nya
                matchSpanTextWithInputValue(tr);

                // Tampilkan Notif
                Notiflix.Notify.success('Syarat berhasil diubah', {
                    position: 'right-bottom',
                    timeout: 1000,
                });

                // Keluar Mode Edit
                toggleEditMode(tr);

            } catch (error) {
                // Tampilkan notif
                const errorMessage = error?.response?.data?.message ?? 'Maaf, ada kesalahan server';
                Notiflix.Notify.failure(errorMessage, {
                    position: 'right-bottom',
                    timeout: 2000,
                });
            }

            /* =============================================== */
            /* =============================================== */

            // Enable button Simpan dan Batal
            btnAksiSimpanDanBatal.prop('disabled', false);

            // Hilangkan loading pada button Simpan
            btnSimpan.removeClass('btn-loading');
        }

        async function deleteSyrt(btn) {
            // Ubah button hapus menjadi object jquery
            const btnHapus = $(btn);

            // Ambil tr dari button Simpan
            const tr = btnHapus.closest('tr');

            // Ambil data encSyarat yang ada di tr
            const encSyarat = tr.find('#encSyarat').val();

            // Tampilkan sweet alert
            const {
                value
            } = await Swal.fire({
                title: 'Peringatan?',
                text: 'Apakah anda yakin ingin menghapus syarat ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus'
            })

            // Jika batal, maka return
            if (!value) return;

            // Disable button Ubah dan Hapus
            btnHapus.closest('div.btnAksi').find('button').prop('disabled', true);

            // Ambil url dari input hidden
            let url = $('#url_destroy').val();

            try {
                const response = await axios.delete(url, {
                    data: {
                        encSyarat: encSyarat,
                    },
                });
                const data = await response.data;

                // Jika sukses, maka hapus tr nya perlahan
                tr.hide('slow', function() {
                    tr.remove();
                });

                // Tampilkan Notif
                Notiflix.Notify.success('Syarat berhasil dihapus', {
                    position: 'right-bottom',
                    timeout: 1000,
                });

            } catch (error) {
                // Tampilkan notif
                const errorMessage = error?.response?.data?.message ?? 'Maaf, ada kesalahan server';
                Notiflix.Notify.failure(errorMessage, {
                    position: 'right-bottom',
                    timeout: 2000,
                });
            }
        }


        function add() {
            // Ambil innerHtml dari template
            let isiTemplate = $('#templateTabelSyarat').html();
            isiTemplate = $(isiTemplate);

            // Ambil jumlah baris yang di tbody tabel syarat
            const jmlbaris = $('#tabelSyarat tbody tr').length;

            // Ubah nilai span yg memiliki class no, dengan jumlah baris ditambah 1
            isiTemplate.find('span.no').text(jmlbaris + 1 + '.');

            // Append isi template ke tbody tabel syarat
            $('#tabelSyarat tbody').append(isiTemplate);
        }

        async function save(btn) {
            // Ubah button simpan menjadi object jquery
            const btnSimpan = $(btn);

            // Disable button Simpan dan Batal
            const btnAksiSimpanDanBatal = btnSimpan.closest('div.btnAksi').find('button');
            btnAksiSimpanDanBatal.prop('disabled', true);

            // Tambahkan loading pada button Simpan
            btnSimpan.addClass('btn-loading');


            /* ==================================================== */
            /* Simpan Syarat Beasiswa Baru */
            /* ==================================================== */

            // Ambil tr dari button Simpan
            const tr = btnSimpan.closest('tr');

            // Ambil semua input yang ada di tr
            const semuaInput = tr.find(':input');

            // Buat satu object untuk menampung data request
            const reqData = {};
            // Lalu masukkan semua nilai input ke object tsb
            for (const clss of semuaClass) {
                reqData[clss] = semuaInput.filter(`.${clss}`).val();
            }

            // Masukkan juga nilai encSyarat ke object tsb
            reqData['encSyarat'] = tr.find('#encSyarat').val();

            // Ambil url dari input hidden
            let url = $('#url_store').val();


            try {
                const response = await axios.post(url, reqData);
                const data = await response.data;

                for (const clss of semuaClass) {
                    // Ambil input yang class nya sama dengan class yang di looping
                    const inputElm = semuaInput.filter(`.${clss}`);

                    // Set nilai input agar sesuai dengan syarat yang diupdate
                    inputElm.val(data.syarat[clss]);

                    // Kalau input nya bertipe textarea, maka set juga teks nya
                    if (inputElm.is('textarea')) inputElm.text(data.syarat[clss]);

                    // Set atribut data-default nya
                    inputElm.data('default', data.syarat[clss]);
                }

                // Update nilai encSyarat dengan nilai yang baru
                tr.find('#encSyarat').val(data.encSyarat);

                // Samakan teks span dengan input nya
                matchSpanTextWithInputValue(tr);

                // Tampilkan Notif
                Notiflix.Notify.success('Syarat berhasil diubah', {
                    position: 'right-bottom',
                    timeout: 1000,
                });

                // Keluar Mode Edit
                toggleEditMode(tr);

                // Ubah attribut onclick button Simpan menjadi update()
                btnSimpan.attr('onclick', 'update(this)');

                // Ubah attribut onclick button Batal menjadi cancel()
                btnSimpan.siblings('button').attr('onclick', 'cancel(this)');

            } catch (error) {
                // Tampilkan notif
                const errorMessage = error?.response?.data?.message ?? 'Maaf, ada kesalahan server';
                Notiflix.Notify.failure(errorMessage, {
                    position: 'right-bottom',
                    timeout: 2000,
                });
            }

            /* ==================================================== */
            /* ==================================================== */


            // Enable button Simpan dan Batal
            btnAksiSimpanDanBatal.prop('disabled', false);

            // Hilangkan loading pada button Simpan
            btnSimpan.removeClass('btn-loading');

        }

        function cancelAdd(btn) {
            // Hapus TR dari button Batal
            $(btn).closest('tr').remove();
        }

        function matchSpanTextWithInputValue(tr) {

            // Ambil semua input yang ada di tr
            const semuaInput = tr.find(':input');

            // Looping semua class
            for (const clss of semuaClass) {
                // Ambil input yang class nya sama dengan class yang dilooping
                const input = semuaInput.filter(`.${clss}`);

                // Kalau input nya bertipe select, maka ambil teks dari option yang selected
                if (input.is('select')) {
                    teks = input.find(':selected').text().trim();
                }
                // Kalau input nya bertipe number, maka ambil teks dari value
                else if (input.is("[type='number']")) {
                    teks = input.val();
                }
                // Selain itu, maka ambil teks nya langsung
                else {
                    teks = input.text().trim();
                }

                // Ambil span di tr yang class nya sama dengan class yang dilooping,
                // Lalu ubah teks nya
                tr.find(`span.${clss}`).text(teks);
            }

        }
    </script>
@endpush
