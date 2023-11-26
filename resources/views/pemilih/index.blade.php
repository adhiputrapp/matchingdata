<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <!-- Tautan Bootstrap 5 CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <!-- Tautan Bootstrap 5 JavaScript dan Popper.js CDN, diarahkan ke akhir dokumen sebelum tag </body> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->role }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('filter') }}"
                                        ">
                                        {{ __('Filter') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('matching') }}"
                                        ">
                                        {{ __('Matching') }}
                                    </a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required><br>
            <input type="text" name="sumber" placeholder="Sumber" required><br>
            <button type="submit">Import</button><br>
        </form>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
        {{-- <select id="filterDesa" class="form-select mb-3">
            <option value="">All</option>
            @foreach ($desaValues as $desa)
                <option value="{{ $desa }}">{{ $desa }}</option>
            @endforeach
        </select> --}}
        @php
            $korkabs = '';
            $korkabscount = 1;
            $kecamatans = '';
            $korcams = '';
            $no = 1;

        @endphp
        <div class="container-fluid">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Korkab</th>
                        <th>Kecamatan</th>
                        <th>Korcam</th>
                        <th>Pendamping</th>
                        <th>Desa</th>
                        <th>KPM</th>

                        <th>TPS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td colspan="7" style="background: yellow;">{{ $result->korkab }}</td>
                        </tr>
                        @foreach (json_decode($result->result, true) as $data)
                            @foreach ($data['desa_kpm'] as $index => $desa)
                                <tr>
                                    @if ($index === 0)
                                        <td rowspan="{{ count($data['desa_kpm']) }}"></td>
                                        <td rowspan="{{ count($data['desa_kpm']) }}">{{ $data['Kecamatan'] }}</td>
                                        <td rowspan="{{ count($data['desa_kpm']) }}">{{ $data['korcam'] }}</td>
                                        <td rowspan="{{ count($data['desa_kpm']) }}">{{ $data['pendamping'] }}</td>
                                    @endif
                                    <td>{{ $desa['desa'] }}</td>
                                    <td>{{ count($desa['kpm']) }}</td>
                                    <td>{{ $desa['tps'] }}</td>
                                </tr>
                                @php
                                    // Lakukan inisialisasi hanya pada indeks pertama setiap desa
                                    if ($index === 0) {
                                        $no++;
                                    }
                                @endphp
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>



        {{-- <div id="result" class="mt-3">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div> --}}
        {{-- 
            <div class="container mt-5">
                <h2>Data Table</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">NAMA_KORKAB</th>
                            <th scope="col">NO HP KORKAB</th>
                            <th scope="col">KECAMATAN</th>
                            <th scope="col">NAMA KORCAM</th>
                            <th scope="col">NO HP KORCAM</th>
                            <th scope="col">NAMA PENDAMPING</th>
                            <th scope="col">NO HP PENDAMPING</th>
                            <th scope="col">DESA</th>
                            <th scope="col">NAMA KPM</th>
                            <th scope="col">NO HP KKPM</th>
                            <th scope="col">RT</th>
                            <th scope="col">RW</th>
                            <th scope="col">TPS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($pemilih as $item)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $item->korkab }}</td>
                                <td>{{ $item->no_hp_korkab }}</td>
                                <td>{{ $item->kecamatan }}</td>
                                <td>{{ $item->korcam }}</td>
                                <td>{{ $item->no_hp_korcam }}</td>
                                <td>{{ $item->pendamping }}</td>
                                <td>{{ $item->no_hp_pendamping }}</td>
                                <td>{{ $item->desa }}</td>
                                <td>{{ $item->kpm }}</td>
                                <td>{{ $item->no_hp_kpm }}</td>
                                <td>{{ $item->rt }}</td>
                                <td>{{ $item->rw }}</td>
                                <td>{{ $item->tps }}</td>
                            </tr>
                            @php
                                $no++;
                            @endphp
                        @endforeach
                        <!-- Tambahkan baris-baris data sesuai dengan data yang dimiliki -->
                    </tbody>
                </table>
            </div> --}}

        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom Script for Filter and Limit -->


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('myChart').getContext('2d');
            var data = {
                labels: ['KERTASARI', 'TEGALREJA', 'CIGADUNG', 'CIAWI', 'PENANGGAPAN', 'BLANDONGAN', 'CIPAJANG',
                    'CIMUNDING', 'MALAHAYU', 'KARANGMAJA', 'DUKUHJERUK', 'BANDUNGSARI', 'CIBUNIWANGI',
                    'SINDANGHEULA', 'BANJARHARJO', 'LONGKRANG DUKUH', 'CIBENDUNG', 'PENDE', 'TIWULANDU',
                    'CIKUYA', 'PAREREAJA', 'BANJARLOR', 'KUBANGJERO', 'SUKAREJA', 'PADASUGIH',
                    'RANDUSANGA KULON', 'KALIGANGSA WETAN', 'LEMBARAWA', 'TERLANGU', 'PULOSARI',
                    'Randusanga Wetan', 'PASARBATANG', 'PEMARON', 'KEDUNGUTER', 'PAGEJUGAN', 'WANGANDALEM',
                    'KALIWLINGI', 'BREBES', 'KALIGANGSA KULON', 'KRASAK', 'BANJARANYAR', 'GANDASULI',
                    'PASAR BATANG', 'KARANGBALE', 'LUWUNGGEDE', 'SLATRI', 'SITANGGAL'
                ],
                datasets: [{
                        label: 'AGUS SALEH',
                        data: [0, 0, 0, 0, 88, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                            0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0
                        ],
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'ARIF SURATMAN',
                        data: [0, 0, 0, 0, 0, 60, 80, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                            0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0
                        ],
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'AULIA ARIEF LUTPHI',
                        data: [0, 0, 0, 0, 0, 0, 0, 33, 121, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                            0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0
                        ],
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                    // Tambahkan dataset lain sesuai kebutuhan
                ]
            };
            var options = {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });
        });
    </script>
</body>

</html>
