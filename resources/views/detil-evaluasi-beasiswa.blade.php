@extends('layouts.app', ['navbar' => 'evaluasi'])

@section('html_title', 'Detail Evaluasi Beasiswa')

@php
    use App\Models\Departemen;
    use App\Models\SyaratBeasiswa;
    use App\Models\SyaratPesertaBeasiswa;
    use App\Models\KesimpulanBeasiswa;
@endphp

@push('css')
    <style>
        .mhs-photo {
            width: 30%;
        }

        @media (min-width: 992px) {
            .mhs-photo {
                width: 50%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-wrapper">

        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">

                @include('layouts.alert')

                <div class="row g-2 align-items-center">
                    <div class="col">
                        <a class="btn btn-secondary mb-3" href="{{ route('index-evaluasi-beasiswa') }}">
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
                            Detail Evaluasi Beasiswa
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
                                <div class="row">
                                    <div class="col-lg-9">
                                        <div class="card-title">Informasi Mahasiswa</div>
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
                                            <span class="ms-2">NIM</span> : <strong>{{ $penerima->nim }}</strong>
                                        </div>
                                        <div class="mb-2 d-flex">
                                            <div class="me-1">
                                                <svg class="icon icon-tabler icon-tabler-id-badge-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M7 12h3v4h-3z"></path>
                                                    <path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6"></path>
                                                    <path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
                                                    <path d="M14 16h2"></path>
                                                    <path d="M14 12h4"></path>
                                                </svg>
                                            </div>
                                            <span class="ms-2 me-1" style="white-space: nowrap">Nama</span> :
                                            <div class="ms-2 fw-bold">{{ $penerima->nama }}</div>
                                        </div>
                                        <div class="mb-2 d-flex">
                                            <div class="me-1">
                                                <svg class="icon icon-tabler icon-tabler-school" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                                                    <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                                                </svg>
                                            </div>
                                            <span class="ms-2 me-1" style="white-space: nowrap">Beasiswa</span> :
                                            <div class="ms-2 fw-bold">{{ $penerima->jenis_beasiswa_pmb->keterangan ?? null }}</div>
                                        </div>
                                        <div class="mb-2 d-flex">
                                            <div class="me-1">
                                                <svg class="icon icon-tabler icon-tabler-school" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                                                    <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                                                </svg>
                                            </div>
                                            <span class="ms-2 me-1" style="white-space: nowrap">Info Beasiswa</span> :
                                            <div class="ms-2 fw-bold">{{ $penerima->jenis_beasiswa_pmb->nama ?? null }}</div>
                                        </div>
                                        <div class="mb-2">
                                            <svg class="icon icon-tabler icon-tabler-calendar" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path>
                                                <path d="M16 3v4"></path>
                                                <path d="M8 3v4"></path>
                                                <path d="M4 11h16"></path>
                                                <path d="M11 15h1"></path>
                                                <path d="M12 15v3"></path>
                                            </svg>
                                            <span class="ms-2">Semester</span> : <strong>{{ session('semester') }}</strong>
                                        </div>

                                    </div>

                                    <div class="col">
                                        <div class="text-center">
                                            <img class="mhs-photo" src="https://sicyca.dinamika.ac.id/API/get_mhs_photo.php?nim={{ $penerima->nim }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="subheader">
                                    <svg class="icon icon-tabler icon-tabler-checkup-list" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                                        <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                        <path d="M9 14h.01"></path>
                                        <path d="M9 17h.01"></path>
                                        <path d="M12 16l1 1l3 -3"></path>
                                    </svg>
                                    Status Mahasiswa Saat Ini
                                </div>
                                <div class="h3 m-0">
                                    {{ $hismf->nama_status }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="subheader">
                                    <svg class="icon icon-tabler icon-tabler-stars" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M17.8 19.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z">
                                        </path>
                                        <path
                                            d="M6.2 19.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z">
                                        </path>
                                        <path
                                            d="M12 9.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z">
                                        </path>
                                    </svg>
                                    IPS (Indeks Prestasi Semester)
                                </div>
                                <div class="h3 m-0">
                                    {{ $hismf->ips ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="subheader">
                                    <svg class="icon icon-tabler icon-tabler-award" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 9m-6 0a6 6 0 1 0 12 0a6 6 0 1 0 -12 0"></path>
                                        <path d="M12 15l3.4 5.89l1.598 -3.233l3.598 .232l-3.4 -5.889"></path>
                                        <path d="M6.802 12l-3.4 5.89l3.598 -.233l1.598 3.232l3.4 -5.889"></path>
                                    </svg>
                                    SSKM (Standar Soft Skill Kegiatan Mahasiswa)
                                </div>
                                <div class="h3 m-0">
                                    {{ $sskm }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Evaluasi Bagian Yang LOGIN -->
                <form id="formEvaluasi" action="{{ auth()->user()->kabag_only ? route('simpan-detil-evaluasi') : null }}" method="POST">
                    <input id="status_kesimpulan" name="status_kesimpulan" type="hidden">
                    <input id="nim" name="nim" type="hidden" value="{{ $penerima->nim }}">
                    <input id="kd_jns_bea_pmb" name="kd_jns_bea_pmb" type="hidden" value="{{ $penerima->jenis_beasiswa_pmb->kd_jenis ?? null }}">
                    <input id="smt" name="smt" type="hidden" value="{{ session('semester') }}">
                    <input id="alasan_evaluasi" name="alasan_evaluasi" type="hidden">

                    @csrf

                    @php
                        // Ambil nama bagian dari user yg login
                        $nama_bagian_user = auth()->user()->departemen->nama ?? null;
                    @endphp

                    <div class="row mt-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <label class="form-label">
                                            Evaluasi Bagian {{ ucwords(strtolower($nama_bagian_user)) }}
                                        </label>

                                        <div class="text-muted mb-3">
                                            @if (!auth()->user()->is_keuangan)
                                                <!-- Tampilkan caption ini jika yang login BUKAN KEUANGAN -->
                                                Silahkan centang ketentuan-ketentuan dibawah ini bila penerima beasiswa memenuhi ketentuan.
                                                <br>
                                                Bila penerima beasiswa tidak memenuhi ketentuan, maka tidak perlu dicentang.
                                            @else
                                                <!-- Tampilkan caption ini jika yang login adalah KEUANGAN -->
                                                Bagian Keuangan adalah tahap terakhir dalam proses evaluasi beasiswa mahasiswa.
                                                <br>
                                                Bagian Keuangan dapat meloloskan beasiswa mahasiswa meskipun bagian lain tidak mencentang semua syarat.
                                                <br>
                                                Klik tombol "Lolos", untuk meloloskan beasiswa mahasiswa
                                                <br>
                                                atau
                                                <br>
                                                Klik tombol "Tidak Lolos", untuk menggugurkan beasiswa mahasiswa.
                                            @endif
                                        </div>

                                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                                            @php
                                                // Ambil syarat beasiswa yang bagian_validasi nya sesuai dengan bagian user yang login
                                                $syaratUser = $semuaSyarat->where('bagian_validasi', auth()->user()->bagian);
                                            @endphp

                                            @foreach ($syaratUser as $syarat)
                                                @php
                                                    $checked = null;

                                                    // ================================================================
                                                    // Mekanisme Auto Centang / Autocheck Evaluasi
                                                    // ================================================================

                                                    // Kalo baca_nilai nya adalah IPS, maka cek IPS nya mhs
                                                    if ($syarat->baca_nilai == SyaratBeasiswa::IPS) {
                                                        $ips = $hismf->ips ?? 0;
                                                        $checked = $ips >= $syarat->nil_min ? 'checked' : null;
                                                    }

                                                    // Kalo baca_nilai nya adalah STSKULIAH, maka cek status kuliah mhs
                                                    if ($syarat->baca_nilai == SyaratBeasiswa::STSKULIAH) {
                                                        $status = $hismf->nama_status ?? null;
                                                        $checked = strtoupper($status) == 'AKTIF' ? 'checked' : null;
                                                    }

                                                    // ================================================================
                                                    // ================================================================

                                                @endphp

                                                <label class="form-selectgroup-item flex-fill">
                                                    <!-- Checkbox -->
                                                    <input class="form-selectgroup-input" name="syarat_beasiswa_yg_dicentang[]" type="checkbox" value="{{ $syarat->kd_syarat }}" {{ $checked }}
                                                        {{ auth()->user()->kabag_only ? null : 'disabled' }}>

                                                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                        <div class="me-3">
                                                            <span class="form-selectgroup-check"></span>
                                                        </div>
                                                        <div class="form-selectgroup-label-content d-flex align-items-center">
                                                            <div class="font-weight-medium">
                                                                {{ $syarat->nm_syarat }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @if ($syaratUser->count() > 0 && auth()->user()->kabag_only && !auth()->user()->is_kabag_keuangan)
                                        <!-- Jika ada syarat yang menjadi evaluasinya bagian user yang login -->
                                        <!-- DAN -->
                                        <!-- yang login adalah Kabag tetapi bukan Kabag Keuangan, maka tampilkan tombol simpan nya -->
                                        <button class="btn btn-success" type="button" onclick="simpan()">
                                            Simpan
                                        </button>
                                    @endif

                                    @if (auth()->user()->is_kabag_keuangan)
                                        <button class="btn btn-success" type="button" onclick="simpan('{{ KesimpulanBeasiswa::LOLOS }}')">
                                            Lolos
                                        </button>
                                        <button class="btn btn-danger ms-2" type="button" onclick="simpan('{{ KesimpulanBeasiswa::TIDAK_LOLOS }}')">
                                            Tidak Lolos
                                        </button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Evaluasi Bagian Yang LOGIN -->



                <!-- Evaluasi Bagian Lainnya -->
                <!-- NOTE : Evaluasi ini read-only bagi user yang login -->
                @php
                    // Ambil semua syarat yang bagian_validasi nya bukan bagian nya user yg login
                    $syaratLain = $semuaSyarat->where('bagian_validasi', '!=', auth()->user()->bagian);

                    // Lakukan grouping terhadap bagian_validasinya
                    $syaratLain = $syaratLain->groupBy('bagian_validasi');
                @endphp

                {{-- Looping accordion di bawah ini berdasarkan syarat yang sudah digrouping bagian_validasi nya --}}
                @foreach ($syaratLain as $kd_bagian => $syarat)
                    <div class="row mt-3">
                        <div class="col">
                            <div class="card">
                                <div class="accordion" id="accordion-example">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-4">
                                            @php
                                                // Ambil nama bagian dari db
                                                $nama_bagian = Departemen::where('kode', $kd_bagian)->first()->nama ?? null;
                                                // Kalo gk null, maka tambahkan string "Bagian", lalu ubah agar kapital di tiap huruf
                                                $nama_bagian = $nama_bagian ? 'Bagian ' . ucwords(strtolower($nama_bagian)) : 'Lainnya';
                                            @endphp
                                            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-4" type="button" aria-expanded="false">
                                                Evaluasi {{ $nama_bagian }}
                                            </button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="collapse-4" data-bs-parent="#accordion-example">
                                            <div class="accordion-body pt-0">
                                                <div class="">
                                                    <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">

                                                        @foreach ($syarat as $syt)
                                                            @php
                                                                // Ambil nilai status dari syarat peserta beasiswa jika ada
                                                                // Kalau tidak ada, maka kembalikan null
                                                                $syarat_peserta_beasiswa = $penerima->syarat_peserta->where('kd_syarat', $syt->kd_syarat)->first()->status ?? null;

                                                                // Kalau status nya adalah lolos, maka checkbox nya tercentang
                                                                $checked = $syarat_peserta_beasiswa == SyaratPesertaBeasiswa::LOLOS ? 'checked' : '';
                                                            @endphp

                                                            <label class="form-selectgroup-item flex-fill">

                                                                <input class="form-selectgroup-input" name="syarat_lain[]" type="checkbox" value="{{ $syt->kd_syarat }}" disabled {{ $checked }}>

                                                                <div class="form-selectgroup-label d-flex align-items-center p-3" style="border-color: transparent; cursor: default;">
                                                                    <div class="me-3 align-self-start">
                                                                        <span class="form-selectgroup-check"></span>
                                                                    </div>
                                                                    <div class="form-selectgroup-label-content d-flex align-items-center">
                                                                        <div class="font-weight-medium">
                                                                            {{ $syt->nm_syarat }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        @endforeach

                                                        @php
                                                            $simpulBagian = $penerima->simpul_bagian->where('bagian', $kd_bagian)->first();
                                                        @endphp

                                                        <!-- Jika Simpul Bagian ada isi nya, maka tampilkan alasannya -->
                                                        @if ($simpulBagian)
                                                            <!-- Alasan bila Bagian tidak meloloskan mahasiswa -->
                                                            <div class="ps-4 pt-2">
                                                                <span class="fw-bold">Alasan tidak meloloskan : </span>
                                                                <p>
                                                                    {{ $simpulBagian->keterangan }}
                                                                </p>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Evaluasi Bagian Lainnya -->


            </div>
        </div>

    </div>

@endsection

@push('js')
    <script>
        function simpan(status = null) {
            // Bagian Keuangan adalah gerbang terakhir pengecekan seluruh evaluasi
            // Kalo yang login adalah Kabag Keuangan, maka cek tombol apa yang di klik (Lolos / Tidak Lolos)
            @if (auth()->user()->is_kabag_keuangan)
                // Kalo Kabag Keuangan mengklik Tidak Lolos, maka masuk ke kesimpulanBuruk
                if (status == '{{ KesimpulanBeasiswa::TIDAK_LOLOS }}') {
                    kesimpulanBuruk();
                    return;
                }

                // Kalo Kabag Keuangan mengklik Lolos, cek dulu apakah semua bagian sudah mencentang syarat
                // Jika ada syarat yang belum tercentang, maka masuk ke kesimpulanBaikDenganAlasan

                // Ambil semua checkbox yang beratribut name="syarat_lain[]"
                let checkboxes_lain = document.querySelectorAll('input[name="syarat_lain[]"]');

                // Periksa apakah semua checkbox nya tercentang
                let semuaLainTercentang = [...checkboxes_lain].every(checkbox => checkbox.checked);

                if (!semuaLainTercentang) {
                    kesimpulanBaikDenganAlasan();
                    return;
                }

                kesimpulanBaik();
                return;
            @endif


            // Ambil semua checkbox yang beratribut name="syarat_beasiswa_yg_dicentang[]"
            let checkboxes = document.querySelectorAll('input[name="syarat_beasiswa_yg_dicentang[]"]');

            // Periksa apakah semua checkbox nya tercentang
            let semuaTercentang = [...checkboxes].every(checkbox => checkbox.checked);

            if (!semuaTercentang) {
                kesimpulanBuruk();
                return;
            }

            kesimpulanBaik();

        }

        async function kesimpulanBaik() {
            const text = `Evaluasi yang sudah disimpan akan dianggap <span class="fw-bolder">FINAL</span> dan tidak bisa diubah kembali.`;

            const {
                value
            } = await Swal.fire({
                title: 'Anda yakin?',
                html: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                // cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, simpan'
            })

            if (!value) return;

            document.getElementById('status_kesimpulan').value = '{{ KesimpulanBeasiswa::LOLOS }}';
            document.getElementById('formEvaluasi').submit();
        }

        async function kesimpulanBaikDenganAlasan() {
            let judul = `
                Ada evaluasi yang <span class="fw-bolder">BELUM TERCENTANG</span>.
                <br>
                Tetapi anda mengklik tombol <span class="fw-bolder">LOLOS</span> sehingga mahasiswa ybs <span class="fw-bolder">AKAN LOLOS</span> dan beasiswanya akan <span class="fw-bolder">DILANJUTKAN</span>.
                <br>
                Apakah anda yakin ingin melanjutkan?
            `;

            const {
                value
            } = await Swal.fire({
                title: 'Anda yakin?',
                html: judul,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                // cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, simpan'
            })

            if (!value) return;

            judul = `
                Mohon sebutkan <span class="fw-bold">alasan</span> anda <span class="fw-bold">MELOLOSKAN</span> mahasiswa ybs.
            `;

            // Untuk menampung jawaban alasan
            let alasan = "";

            const {
                value: lanjutkan
            } = await Swal.fire({
                html: judul,
                input: 'text',
                confirmButtonColor: '#3085d6',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Simpan',
                inputValidator: (value) => {
                    // Kalo isian nya kosong
                    if (!value) return 'Alasan harus diisi.'
                    alasan = value;
                }
            })

            if (!lanjutkan) return

            document.getElementById('status_kesimpulan').value = '{{ KesimpulanBeasiswa::LOLOS }}';
            document.getElementById('alasan_evaluasi').value = alasan;
            document.getElementById('formEvaluasi').submit();
        }

        async function kesimpulanBuruk() {
            let judul = `
                Ada evaluasi yang <span class="fw-bolder">BELUM TERCENTANG</span>.
                <br>
                Mahasiswa ybs <span class="fw-bolder">TIDAK AKAN LOLOS</span> dan beasiswanya akan <span class="fw-bolder">DICABUT</span>.
                <br>
                Apakah anda yakin ingin melanjutkan?
            `;

            // Kalau yang login Kabag Keuangan, ganti judul nya
            @if (auth()->user()->is_kabag_keuangan)
                judul = `
                    Apakah anda yakin?
                    <br>
                    Mahasiswa ybs <span class="fw-bolder">TIDAK AKAN LOLOS</span> dan beasiswanya akan <span class="fw-bolder">DICABUT</span>.
                `;
            @endif

            const {
                value
            } = await Swal.fire({
                title: 'PERHATIAN!',
                html: judul,
                icon: 'warning',
                showCancelButton: true,
                // confirmButtonColor: '#3085d6',
                // cancelButtonColor: '#d33',
                confirmButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, lanjut'
            })

            if (!value) return;

            judul = `
                Mohon sebutkan <span class="fw-bold">alasan</span> anda <span class="fw-bold">TIDAK MELOLOSKAN</span> mahasiswa ybs.
            `;

            // Untuk menampung jawaban alasan
            let alasan = "";

            const {
                value: lanjutkan
            } = await Swal.fire({
                html: judul,
                input: 'text',
                confirmButtonColor: '#d33',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Simpan',
                inputValidator: (value) => {
                    // Kalo isian nya kosong
                    if (!value) return 'Alasan harus diisi.'
                    alasan = value;
                }
            })

            if (!lanjutkan) return

            document.getElementById('status_kesimpulan').value = '{{ KesimpulanBeasiswa::TIDAK_LOLOS }}';
            document.getElementById('alasan_evaluasi').value = alasan;
            document.getElementById('formEvaluasi').submit();
        }
    </script>
@endpush
