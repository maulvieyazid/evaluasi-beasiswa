@extends('layouts.app', ['navbar' => 'evaluasi'])

@section('html_title', 'Detail Evaluasi Beasiswa')

@section('content')
    <div class="page-wrapper">

        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">

                @include('layouts.alert')

                <div class="row g-2 align-items-center">
                    <div class="col">
                        <a href="{{ route('index-evaluasi-beasiswa') }}" class="btn btn-secondary mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
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
                                <div class="card-title">Informasi Mahasiswa</div>
                                <div class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                                        <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M15 8l2 0"></path>
                                        <path d="M15 12l2 0"></path>
                                        <path d="M7 16l10 0"></path>
                                    </svg>
                                    NIM : <strong>23410100026</strong>
                                </div>
                                <div class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id-badge-2 me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 12h3v4h-3z"></path>
                                        <path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6"></path>
                                        <path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
                                        <path d="M14 16h2"></path>
                                        <path d="M14 12h4"></path>
                                    </svg>
                                    Nama : <strong>Erlangga Harrys Setyawan</strong>
                                </div>
                                <div class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-school me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                                        <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                                    </svg>
                                    Beasiswa: <strong>Beasiswa Kuliah 0 Rupiah</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="subheader">IPS (Indeks Prestasi Semester)</div>
                                <div class="h3 m-0">3.50</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="subheader">SSKM (Standar Soft Skill Kegiatan Mahasiswa)</div>
                                <div class="h3 m-0">115</div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Evaluasi Bagian Keuangan -->
                <div class="row mt-3">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <label class="form-label">Evaluasi Bagian Keuangan</label>
                                    <div class="text-muted mb-3">
                                        Silahkan centang ketentuan-ketentuan dibawah ini, bila penerima beasiswa memenuhi ketentuan.
                                    </div>

                                    <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">

                                        <label class="form-selectgroup-item flex-fill">

                                            <input type="checkbox" name="form-project-manager[]" value="1" class="form-selectgroup-input">

                                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                <div class="me-3">
                                                    <span class="form-selectgroup-check"></span>
                                                </div>
                                                <div class="form-selectgroup-label-content d-flex align-items-center">
                                                    <div class="font-weight-medium">
                                                        Evaluasi Indeks Prestasi Semester (IPS) yang harus dicapai setiap semester >= 3.00
                                                    </div>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="form-selectgroup-item flex-fill">

                                            <input type="checkbox" name="form-project-manager[]" value="2" class="form-selectgroup-input">

                                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                <div class="me-3">
                                                    <span class="form-selectgroup-check"></span>
                                                </div>
                                                <div class="form-selectgroup-label-content d-flex align-items-center">
                                                    <div class="font-weight-medium">
                                                        Tidak diperkenankan untuk : (a) pindah ke program studi lain, (b) mengajukan cuti semester
                                                    </div>
                                                </div>
                                            </div>
                                        </label>

                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="button" class="btn btn-success" onclick="simpan()">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Evaluasi Bagian Keuangan -->



                <!-- Evaluasi Bagian Kemahasiswaan -->
                <div class="row mt-3">
                    <div class="col">
                        <div class="card">
                            <div class="accordion" id="accordion-example">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-4" aria-expanded="false">
                                            Evaluasi Bagian Kemahasiswaan
                                        </button>
                                    </h2>
                                    <div id="collapse-4" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                                        <div class="accordion-body pt-0">
                                            <div class="">
                                                <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">

                                                    <label class="form-selectgroup-item flex-fill">

                                                        <input type="checkbox" name="form-project-manager[]" value="1" class="form-selectgroup-input" disabled checked>

                                                        <div class="form-selectgroup-label d-flex align-items-center p-3" style="border-color: transparent">
                                                            <div class="me-3">
                                                                <span class="form-selectgroup-check"></span>
                                                            </div>
                                                            <div class="form-selectgroup-label-content d-flex align-items-center">
                                                                <div class="font-weight-medium text-muted">
                                                                    Bersedia mematuhi peraturan yang berlaku di Universitas Dinamika
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>

                                                    <label class="form-selectgroup-item flex-fill">

                                                        <input type="checkbox" name="form-project-manager[]" value="2" class="form-selectgroup-input" disabled>

                                                        <div class="form-selectgroup-label d-flex align-items-center p-3" style="border-color: transparent">
                                                            <div class="me-3">
                                                                <span class="form-selectgroup-check"></span>
                                                            </div>
                                                            <div class="form-selectgroup-label-content d-flex align-items-center">
                                                                <div class="font-weight-medium text-muted">
                                                                    Bersedia berkontribusi dan terlibat aktif dalam kegiatan Universitas Dinamika dan Bagian Penerimaan Mahasiswa Baru
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Evaluasi Bagian Kemahasiswaan -->


            </div>
        </div>

    </div>

@endsection

@push('js')
    <script>
        function simpan() {
            Swal.fire({
                title: 'Anda yakin?',
                text: "Evaluasi yang sudah disimpan akan dianggap final.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, simpan'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        }
    </script>
@endpush
