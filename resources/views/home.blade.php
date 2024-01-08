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
                                            @foreach ($semuaSmt as $smt)
                                                <option value="{{ $smt->smt }}">
                                                    {{ $smt->smt }}
                                                </option>
                                            @endforeach
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
                                            @foreach ($semuaSmt as $smt)
                                                <option value="{{ $smt->smt }}">
                                                    {{ $smt->smt }}
                                                </option>
                                            @endforeach
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

        <!-- Modal Detail Chart -->
        <div class="modal modal-blur fade" id="modal-detail-chart" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="detail-chart-content"></div>
                        <div class="loading">Sedang Memuat...</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.js') }}"></script>

    <script>
        // Variabel global
        var elmModalDtlChrt;
        var modalDtlChrt;

        document.addEventListener('DOMContentLoaded', function(e) {
            $('.pilih-smt').select2({
                templateSelection: function(state) {
                    return `Semester ${state.text}`;
                },
            });

            elmModalDtlChrt = $('#modal-detail-chart');
            modalDtlChrt = bootstrap.Modal.getOrCreateInstance(elmModalDtlChrt);
        });


        // Fungsi untuk membuka modal detail chart dan merubah title nya
        function bootModalDtlChart({
            title
        }) {
            // Kosongkan isi modal
            elmModalDtlChrt.find('#detail-chart-content').empty();
            // Tampilkan Loading
            elmModalDtlChrt.find('.loading').removeClass('d-none');
            // Ubah title modal
            elmModalDtlChrt.find('.modal-title').text(title);
            // Buka modal
            modalDtlChrt.show();
        }

        // Fungsi untuk memperbarui isi modal detail chart
        function updateModalDtlChart({
            htmlContent
        }) {
            // Masukkan isi html ke dalam modal
            elmModalDtlChrt.find('#detail-chart-content').html(htmlContent);
            // Sembunyikan Loading
            elmModalDtlChrt.find('.loading').addClass('d-none');
        }
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
                    events: {
                        click: async function(event, chartContext, config) {
                            // Kalo point yang diklik index nya kurang dari 0 maka return
                            if (config.dataPointIndex < 0) return;

                            const smt = config.globals.categoryLabels[config.dataPointIndex];

                            bootModalDtlChart({
                                title: `Detail Jumlah Penerima Beasiswa Semester ${smt}`
                            });

                            let url = "{{ route('chart.get.detail-jml-penerima-per-smt', ['smt' => ':smt']) }}";
                            url = url.replace(':smt', smt);

                            const response = await axios.get(url, {
                                retry: 2
                            });
                            const data = await response.data;

                            updateModalDtlChart({
                                htmlContent: data
                            });

                        },
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
                    // text: 'Sedang Memuat...'
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
                    height: '500px',
                    toolbar: {
                        show: false,
                    },
                    events: {
                        dataPointSelection: async function(event, chartContext, config) {
                            const dataBeasiswa = config.w.globals.initialSeries[config.seriesIndex].data[config.dataPointIndex];
                            const smt = $('#pilihSmtJnsBea').val();

                            bootModalDtlChart({
                                title: `Detail ${dataBeasiswa.x} Semester ${smt}`
                            });

                            let url = "{{ route('chart.get.detail-jml-penerima-per-jenis-beasiswa', ['smt' => ':smt', 'kd_jenis' => ':kd_jenis']) }}";
                            url = url.replace(':smt', smt).replace(':kd_jenis', dataBeasiswa.kd_jenis);

                            const response = await axios.get(url, {
                                retry: 2
                            });
                            const data = await response.data;

                            updateModalDtlChart({
                                htmlContent: data
                            });

                        },
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
                    events: {
                        dataPointSelection: async function(event, chartContext, config) {
                            // Default status adalah lolos
                            let status = '{{ \App\Models\KesimpulanBeasiswa::LOLOS }}';

                            // Nilai pie chart yang diklik
                            const clickedPoint = config.w.config.labels[config.dataPointIndex];

                            // Kalo pie chart yang diklik adalah gugur, maka ganti status nya menjadi tidak lolos
                            status = clickedPoint.toUpperCase() == 'GUGUR' ? '{{ \App\Models\KesimpulanBeasiswa::TIDAK_LOLOS }}' : status;

                            // Ambil nilai semester
                            const smt = $('#pilihSmtPrsn').val();

                            bootModalDtlChart({
                                title: `Detail Penerima Beasiswa ${clickedPoint} Semester ${smt}`
                            });

                            let url = "{{ route('chart.get.detail-prsnts-penerima-aktf-ggr', ['smt' => ':smt', 'status' => ':status']) }}";
                            url = url.replace(':smt', smt).replace(':status', status);

                            const response = await axios.get(url, {
                                retry: 2
                            });
                            const data = await response.data;

                            updateModalDtlChart({
                                htmlContent: data
                            });
                        },
                    },
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
