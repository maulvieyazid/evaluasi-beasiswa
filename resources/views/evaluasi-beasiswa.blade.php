@extends('layouts.app', ['navbar' => 'evaluasi'])

@section('html_title', 'Evaluasi Beasiswa')

@section('content')
    <div class="page-wrapper">

        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">

                @include('layouts.alert')

                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Evaluasi Beasiswa Semester {{ session('semester') }}
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
                                <table class="table card-table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Semester</th>
                                            <th style="width: 50%">Beasiswa</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($semuaPenerima as $penerima)
                                            <tr>
                                                <td>{{ $penerima->nim }}</td>
                                                <td>{{ $penerima->mahasiswa->nama ?? null }}</td>
                                                <td>{{ session('semester') }}</td>
                                                <td>
                                                    {{ $penerima->jenis_beasiswa_pmb->keterangan ?? null }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-outline-primary w-100 btn-sm" href="{{ route('detil-evaluasi-beasiswa', [$penerima->nim]) }}">
                                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
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
