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

        <main class="py-4">
            <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Choose Excel File</label>
                    <input type="file" class="form-control" id="file" name="file" accept=".xlsx, .xls"
                        required>
                </div>
                <button type="submit" class="btn btn-primary">Import</button>
            </form>

            <!-- Filter by Desa -->
            <label for="filterDesa">Filter by Desa:</label>
            <select id="filterDesa" class="form-select mb-3">
                <option value="">All</option>
                @foreach ($desaValues as $desa)
                    <option value="{{ $desa }}">{{ $desa }}</option>
                @endforeach
            </select>

            <div class="container-fluid">
                <h2>Data Table</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">PENDAMPING</th>
                            <!-- Loop through unique DESA values to create th elements -->
                            @foreach ($desaValues as $desa)
                                <th scope="col">{{ $desa }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through the pivotData to create rows -->
                        @foreach ($pivotData as $row)
                            <tr>
                                <td>{{ $row->pendamping }}</td>
                                <!-- Loop through the values to create td elements -->
                                @foreach ($desaValues as $desa)
                                    <td>{{ $row[$desa] }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>



            <div id="result" class="mt-3">
                <!-- Display result of filter -->
            </div>
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
    <!-- Custom Script for Filter and Limit -->
    <script>
        $(document).ready(function() {
            // Event handler for filter
            $('#filterDesa').change(function() {
                var selectedDesa = $(this).val();

                // Show/hide rows based on selected desa
                $('tbody tr').each(function() {
                    var rowData = $(this).find('td'); // Ambil semua kolom data pada baris
                    var desaValue = rowData.eq(1).text(); // Ambil nilai pada kolom 'DESA'

                    // Bandingkan nilai 'DESA' dengan opsi yang dipilih
                    if (selectedDesa === '' || desaValue === selectedDesa) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>

</html>
