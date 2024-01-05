@extends('layouts.app', ['navbar' => 'home'])

@section('html_title', 'Home')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}" defer></script>
@endpush

@section('content')
    <div class="page-wrapper">

        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">

                @include('layouts.alert')

                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Selamat Datang
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">

                <div class="row">

                    <!-- Chart Jumlah Penerima Beasiswa Per Semester -->
                    <div class="col-lg-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h3 class="card-title">Jumlah Penerima Beasiswa Per Semester</h3>
                                </div>
                                <div id="chartJmlPerSmt"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Prosentase Penerima Beasiswa Aktif dan Gugur -->
                    <div class="col mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h3 class="card-title">Prosentase Penerima Beasiswa Aktif dan Gugur</h3>
                                    <div class="ms-auto">
                                        <select id="pilihSmtPrsn" class="form-select pilih-smt" style="width: 140px" onchange="updateChartPrsnAktfGgr(this.value)">
                                            <option value="231">231</option>
                                            <option value="222">222</option>
                                            <option value="221">221</option>
                                            <option value="212">212</option>
                                            <option value="211">211</option>
                                            <option value="202">202</option>
                                        </select>

                                    </div>
                                </div>
                                <div id="chartPrsnAktfGgr"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Chart Jumlah Penerima Beasiswa Per Jenis Beasiswa -->
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h3 class="card-title">Jumlah Penerima Beasiswa Per Jenis Beasiswa</h3>
                                    <div class="ms-auto">
                                        <select id="pilihSmtJnsBea" class="form-select pilih-smt" style="width: 140px" onchange="updateChartJmlPerJnsBea(this.value)">
                                            <option value="231">231</option>
                                            <option value="222">222</option>
                                            <option value="221">221</option>
                                            <option value="212">212</option>
                                            <option value="211">211</option>
                                            <option value="202">202</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div id="chartJmlPerJnsBea"></div>
                                    </div>
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
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function(e) {
            $('.pilih-smt').select2({
                templateSelection: function(state) {
                    return `Semester ${state.text}`;
                },
            });
        });
    </script>

    <!-- Config Chart Jumlah Penerima Beasiswa Per Semester -->
    <script>
        async function updateChartJmlPerSmt() {
            let url = "{{ route('chart.get.jml-penerima-per-smt') }}";

            const response = await axios.get(url, {
                retry: 2
            });
            const data = await response.data;

            // Update data series chart
            chartJmlPerSmt.updateOptions({
                series: [{
                    data: data,
                }]
            });
        }

        const chartJmlPerSmt = new ApexCharts(
            document.querySelector("#chartJmlPerSmt"), {
                chart: {
                    type: 'line',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: true,
                },
                stroke: {
                    curve: 'smooth',
                },
                tooltip: {
                    enabled: true,
                    x: {
                        formatter: function(value, opts) {
                            const smt = opts.w.globals.categoryLabels[opts.dataPointIndex];
                            return `Semester ${smt}`;
                        },
                    },
                    y: {
                        formatter: function(value, opts) {
                            return `${value} Orang`;
                        },
                    },
                },
                noData: {
                    text: 'Sedang Memuat...'
                },
                series: [{
                    name: 'Penerima',
                    data: [],
                }],
            }
        );

        chartJmlPerSmt.render();

        document.addEventListener('DOMContentLoaded', function(e) {
            // Set nilai awal chart
            updateChartJmlPerSmt();
        });
    </script>


    <!-- Config Chart Jumlah Penerima Beasiswa Per Jenis Beasiswa -->
    <script>
        async function updateChartJmlPerJnsBea(smt) {
            let url = "{{ route('chart.get.jml-penerima-per-jenis-beasiswa', ['smt' => ':smt']) }}";
            url = url.replace(':smt', smt);

            const response = await axios.get(url, {
                retry: 2
            });
            const data = await response.data;

            // Update data series chart
            chartJmlPerJnsBea.updateOptions({
                series: [{
                    data: data,
                }]
            });
        }

        const chartJmlPerJnsBea = new ApexCharts(
            document.querySelector('#chartJmlPerJnsBea'), {
                chart: {
                    type: 'bar',
                    height: '400px',
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        distributed: true,
                    }
                },
                theme: {
                    palette: 'palette1',
                },
                legend: {
                    show: false,
                },
                tooltip: {
                    enabled: true,
                    y: {
                        formatter: function(value, opts) {
                            return `${value} Orang`;
                        },
                    },
                },
                noData: {
                    // text: 'Sedang Memuat...',
                },
                series: [{
                    name: 'Penerima',
                    data: [],
                }]
            }
        );

        chartJmlPerJnsBea.render();

        document.addEventListener('DOMContentLoaded', function(e) {
            // Set nilai awal chart
            updateChartJmlPerJnsBea("{{ session('semester') }}");
        });
    </script>


    <!-- Config Chart Prosentase Penerima Beasiswa Aktif dan Gugur -->
    <script>
        async function updateChartPrsnAktfGgr(smt) {
            let url = "{{ route('chart.get.prsnts-penerima-aktf-ggr', ['smt' => ':smt']) }}";
            url = url.replace(':smt', smt);

            const response = await axios.get(url, {
                retry: 2
            });
            const data = await response.data;

            // Update data series chart
            chartPrsnAktfGgr.updateOptions({
                series: data
            });
        }

        const chartPrsnAktfGgr = new ApexCharts(
            document.querySelector('#chartPrsnAktfGgr'), {
                chart: {
                    width: 420,
                    type: 'pie',
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300
                        },
                        legend: {
                            position: 'right'
                        }
                    }
                }],
                tooltip: {
                    enabled: true,
                    y: {
                        formatter: function(value, opts) {
                            return `${value} Orang`;
                        },
                    },
                },
                noData: {
                    // text: 'Sedang Memuat...',
                },
                colors: ['#4CAF50', '#FF4560'],
                series: [],
                labels: ['Aktif', 'Gugur'],
            }
        );

        chartPrsnAktfGgr.render();

        document.addEventListener('DOMContentLoaded', function(e) {
            // Set nilai awal chart
            updateChartPrsnAktfGgr("{{ session('semester') }}");
        });
    </script>
@endpush
