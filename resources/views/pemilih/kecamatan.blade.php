<!DOCTYPE html>
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

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        <main>
            <div class="container mt-4">
                <style>
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 10px;
                        /* Atur jarak dari elemen sebelumnya */
                    }

                    th,
                    td {
                        padding: 10px;
                        /* Sesuaikan dengan ukuran padding yang diinginkan */
                        border: 1px solid #ddd;
                        /* Atur border sesuai kebutuhan */
                        text-align: left;
                        /* Sesuaikan dengan alignment yang diinginkan */
                    }
                </style>
                @php

                    $tpss = '';
                    $korcams = '';
                    $pendampings = '';
                    $desas = '';
                    $korcams = '';
                    $no = 1;
                    $total = 0;
                    $kosong = 0;
                    $totalall = [];

                @endphp
                <h2>Data Kecamatan : {{ $kecamatan }}</h2>
                <div id="filter">
                    <h6>Filter Pendamping:</h6>
                    @foreach ($pemilih as $key => $result2)
                        @php

                            if ($desas != $result2->desa || $desas == '') {
                                $desas = $result2->desa;
                                $total = 0;
                            }
                            $total += count(json_decode($result2->kpm_array));
                            if ($desas == $result2->desa && $desas != '') {
                                $totalall[$desas] = $total;
                            }
                        @endphp

                        @if ($pendampings != $result2->pendamping)
                            @php $pendampings = $result2->pendamping; @endphp
                            <label>
                                <input type="checkbox" class="kecamatan-filter" value="{{ $result2->pendamping }}"
                                    checked>
                                {{ $result2->pendamping }}
                            </label>
                        @endif
                    @endforeach
                    {{-- @dd($totalall); --}}
                </div>

                @foreach ($pemilih as $key => $result)
                    <div class="kecamatan-{{ str_replace([' ', '.'], ['-', ''], $result->pendamping) }}">


                        @if ($korcams != $result->korcam)
                            @php $korcams = $result->korcam; @endphp
                            <h6>Kordinator Kecamatan : {{ $result->korcam }}
                            </h6>
                            <hr>
                        @endif

                        @if ($pendampings != $result->pendamping)
                            @php $pendampings = $result->pendamping; @endphp
                            <h6 style="margin-bottom: 10px;margin-top: 10px;">
                                Pendamping :

                                {{ $result->pendamping }}


                            </h6>
                        @endif

                        @if ($desas != $result->desa)
                            @php $desas = $result->desa; @endphp
                            <h6 style="margin-bottom: 10px;margin-top: 10px;">
                                Desa :

                                {{ $result->desa }}
                                <h6 style="margin-bottom: 10px;margin-top: 10px;">
                                    Total Per Desa :

                                    {{ $totalall[$desas] }}
                                </h6>
                            </h6>
                        @endif

                        @if ($tpss != $result->tps)
                            @php $tpss = $result->tps; @endphp
                            <h6 style="margin-bottom: 10px;margin-top: 10px;">
                                TPS :
                                {{ $result->tps }}
                            </h6>
                        @endif
                        <div class="scrollable-list" style="max-height: 300px; overflow-y: auto;">
                            <ul class="list-group w-100">
                                @foreach (json_decode($result->kpm_array) as $index => $kpm)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $kpm }}
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <p class="list-group-item d-flex justify-content-between align-items-center">
                            Total per TPS : {{ count(json_decode($result->kpm_array)) }}
                        </p>

                    </div>
                @endforeach
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".kecamatan-filter").change(function() {
                var kecamatan = $(this).val();
                kecamatan = kecamatan.replace(/\s+/g, '-').replace(/\./g, '');

                if ($(this).prop("checked")) {
                    $(".kecamatan-" + kecamatan).show();
                } else {
                    $(".kecamatan-" + kecamatan).hide();
                }
            });
        });
    </script>
</body>

</html>
