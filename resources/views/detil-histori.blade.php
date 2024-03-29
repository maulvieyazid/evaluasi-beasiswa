@extends('layouts.app', ['navbar' => 'histori'])

@section('html_title', 'Detail Histori Evaluasi Beasiswa')

@php
    use App\Models\SyaratPesertaBeasiswa;
    use App\Models\KesimpulanBeasiswa;
    use App\Models\SimpulBagian;
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
                        <a class="btn btn-secondary mb-3" href="{{ route('index-histori') }}">
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
                            Detail Histori Evaluasi Beasiswa
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
                                            <span class="ms-2">NIM</span> : <strong>{{ $mhs->nim }}</strong>
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
                                            <div class="ms-2 fw-bold">{{ $mhs->nama }}</div>
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
                                            <div class="ms-2 fw-bold">{{ $jenis_bea_pmb->keterangan }}</div>
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
                                            <div class="ms-2 fw-bold">{{ $jenis_bea_pmb->nama }}</div>
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
                                            <span class="ms-2">Semester</span> : <strong>{{ $smt }}</strong>
                                        </div>
                                        <div class="mb-2">
                                            <svg class="icon icon-tabler icon-tabler-checkbox" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M9 11l3 3l8 -8"></path>
                                                <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                                            </svg>
                                            <span class="ms-2">Status</span> :
                                            @php
                                                $status = $kesimpulan->status ?? null;
                                            @endphp
                                            @if ($status == KesimpulanBeasiswa::LOLOS)
                                                <span class="badge bg-green">Lolos</span>
                                            @elseif ($status == KesimpulanBeasiswa::TIDAK_LOLOS)
                                                <span class="badge bg-danger-lt">Tidak Lolos</span>
                                            @elseif (!$status)
                                                <span class="badge bg-cover">Menunggu Evaluasi Keuangan</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="text-center">
                                            <img class="mhs-photo" src="https://sicyca.dinamika.ac.id/API/get_mhs_photo.php?nim={{ $mhs->nim }}">
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
                                    Status Mahasiswa
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


                <form>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <label class="form-label">
                                            Evaluasi Penerima Beasiswa
                                        </label>

                                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                                            @foreach ($semuaSyarat as $syarat)
                                                @php
                                                    // Ambil nilai status dari syarat peserta beasiswa jika ada
                                                    // Kalau tidak ada, maka kembalikan null
                                                    $syarat_peserta_beasiswa = $semuaSyaratPeserta->where('kd_syarat', $syarat->kd_syarat)->first()->status ?? null;

                                                    // Kalau status nya adalah lolos, maka checkbox nya tercentang
                                                    $checked = $syarat_peserta_beasiswa == SyaratPesertaBeasiswa::LOLOS ? 'checked' : '';
                                                @endphp

                                                <label class="form-selectgroup-item flex-fill">
                                                    <input class="form-selectgroup-input" name="syarat_beasiswa[]" type="checkbox" value="{{ $syarat->kd_syarat }}" disabled {{ $checked }}>
                                                    <div class="form-selectgroup-label d-flex align-items-center p-3" style="border-color: transparent; cursor: default;">
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
                            </div>
                        </div>
                    </div>
                </form>


                @php
                    // Ambil SimpulBagian yang status nya lolos
                    // Ini artinya adalah apa alasan Kabag Keuangan meloloskan mhs tersebut
                    $simpulBagianLolos = $semuaSimpulBagian->where('status', SimpulBagian::LOLOS);
                @endphp
                @if ($simpulBagianLolos->count())
                    <div class="row mt-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <label class="form-label">
                                            Bagian yang <span class="bg-success-lt">MELOLOSKAN</span>
                                        </label>

                                        @foreach ($simpulBagianLolos as $simpulBagian)
                                            <div class="ps-4 pt-2">
                                                @php
                                                    $nama_bagian = ucwords(strtolower($simpulBagian->departemen->nama));
                                                @endphp
                                                <span class="fw-bold">{{ $nama_bagian }} : </span> &nbsp;

                                                <span>
                                                    {{ $simpulBagian->keterangan }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @php
                    // Ambil SimpulBagian yang status nya tidak lolos
                    // Ini adalah alasan-alasan dari bagian-bagian lain yang tidak meloloskan mhs tersebut
                    // karena tidak mencentang semua syarat
                    $simpulBagianTidakLolos = $semuaSimpulBagian->where('status', SimpulBagian::TIDAK_LOLOS);
                @endphp
                @if ($simpulBagianTidakLolos->count())
                    <div class="row mt-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <label class="form-label">
                                            Bagian yang <span class="bg-danger-lt">TIDAK MELOLOSKAN</span>
                                        </label>

                                        @foreach ($simpulBagianTidakLolos as $simpulBagian)
                                            <div class="ps-4 pt-2">
                                                @php
                                                    $nama_bagian = ucwords(strtolower($simpulBagian->departemen->nama));
                                                @endphp
                                                <span class="fw-bold">{{ $nama_bagian }} : </span> &nbsp;

                                                <span>
                                                    {{ $simpulBagian->keterangan }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>

    </div>

@endsection

@push('js')
@endpush
