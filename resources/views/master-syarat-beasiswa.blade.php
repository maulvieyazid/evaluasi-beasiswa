@extends('layouts.app', ['navbar' => 'master-syarat'])

@section('html_title', 'Maintenance Syarat Beasiswa')

@push('css')
    <!-- Datatables Bootstrap 5 Theme -->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap5.min.css') }}" />

    <!-- Datatables -->
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}" defer></script>
    <!-- Datatables Bootstrap 5 Theme -->
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap5.min.js') }}" defer></script>
@endpush

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
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered" id="tabelBeasiswa">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Kode</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Keterangan</th>
                                                <th class="text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($semuaBeasiswa as $bea)
                                                <tr>
                                                    <td class="text-center">{{ $bea->kd_jenis }}</td>
                                                    <td>{{ $bea->nama }}</td>
                                                    <td>{{ $bea->keterangan }}</td>
                                                    <td>
                                                        <a href="{{ route('detil.master-syarat-beasiswa', [$bea->kd_jenis]) }}" class="btn btn-outline-primary w-100 btn-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M9 11l3 3l8 -8"></path>
                                                                <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                                                            </svg>
                                                            Syarat
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

    </div>

@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function(e) {
            $('#tabelBeasiswa').DataTable({
                order: [] // <- Mematikan order saat inisialisasi
            });

        });
    </script>
@endpush
