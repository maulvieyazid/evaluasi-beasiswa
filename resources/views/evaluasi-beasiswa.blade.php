@extends('layouts.app', ['navbar' => 'evaluasi'])

@section('html_title', 'Evaluasi Beasiswa')

@php
    use App\Models\Terima;
@endphp

@section('content')
    <div class="page-wrapper">

        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">

                @include('layouts.alert')

                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Evaluasi Beasiswa Semester 231
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
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>NIM</th>
                                            <th {{-- style="width: 20%" --}}>Nama</th>
                                            <th>Semester</th>
                                            <th {{-- style="width: 20%" --}}>Beasiswa</th>
                                            {{-- <th>Ketentuan Terpenuhi</th> --}}
                                            {{-- <th>Status</th> --}}
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($semuaPenerima as $penerima)
                                            <tr>
                                                <td>{{ $penerima->nim }}</td>
                                                <td>{{ $penerima->mahasiswa->nama ?? null }}</td>
                                                <td>{{ Terima::TEMP_SMT }}</td>
                                                <td>
                                                    @php
                                                        // Mengambil nama relasi jenis beasiswa yang sesuai
                                                        $jenis_beasiswa = Terima::getNamaRelasiJnsBea($penerima->pilihan_ke);
                                                    @endphp
                                                    {{ $penerima->{$jenis_beasiswa}->nama ?? null }}
                                                </td>
                                                {{-- <td>
                                                    <div class="progr progress progress-xs">
                                                        <div class="progress-bar bg-primary" style="width: 50%"></div>
                                                    </div>
                                                    <small>2/3</small>
                                                </td> --}}
                                                {{-- <td>
                                                    <span class="badge bg-azure">Draft</span>
                                                </td> --}}
                                                <td>
                                                    <a href="{{ route('detil-evaluasi-beasiswa', [$penerima->nim]) }}" class="btn btn-outline-primary w-100 btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M9 11l3 3l8 -8"></path>
                                                            <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                                                        </svg>
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        {{-- <tr>
                                            <td>23410100032</td>
                                            <td>Nufrisal Akmal Rachman</td>
                                            <td>231</td>
                                            <td>Beasiswa Atlit Juara Tingkat Provinsi</td>
                                            <td>
                                                <div class="progr progress progress-xs">
                                                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                                                </div>
                                                <small>3/3</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-green">Final</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('detil-evaluasi-beasiswa') }}" class="btn btn-outline-primary w-100 btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M9 11l3 3l8 -8"></path>
                                                        <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                                                    </svg>
                                                    Detail
                                                </a>
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
