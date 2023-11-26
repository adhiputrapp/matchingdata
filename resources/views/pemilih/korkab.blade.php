@extends('layouts.main')

@section('content')
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
                    $korkabs = '';
                    $korkabscount = 1;
                    $kecamatans = '';
                    $kecamatans2 = '';
                    $korcams = '';
                    $no = 1;
 
                @endphp
                <h2>Data Korkab : {{ $korkab }}</h2>
                <div id="filter">
                    <h6>Filter Kecamatan:</h6>
                    @foreach ($pemilih as $result)
                        @foreach (json_decode($result->result, true) as $data)
                            @if ($kecamatans != $data['Kecamatan'])
                                @php $kecamatans = $data['Kecamatan']; @endphp
                                <input 
                                type="checkbox" 
                                class="kecamatan-filter" 
                                value="{{ $data['Kecamatan'] }}"
                                checked>
                                <label>
                                    {{ $data['Kecamatan'] }}
                                </label>
                            @endif
                        @endforeach
                    @endforeach
                </div>

                @foreach ($pemilih as $result)
                    @foreach (json_decode($result->result, true) as $data)
                        <div class="kecamatan-{{ $data['Kecamatan'] }}">
                            
                            @if ($kecamatans2 != $data['Kecamatan'])
                                @php $kecamatans2 = $data['Kecamatan']; @endphp
                                <h6 style="margin-bottom: 10px;margin-top: 10px;">
                                    Kecamatan :
                                    <a href="{{ route('filter.kecamatan', $data['Kecamatan']) }}">
                                        {{ $data['Kecamatan'] }}
                                    </a>
                                </h6>
                            @endif

                            @if ($korcams != $data['korcam'])
                                @php $korcams = $data['korcam']; @endphp
                                <h6>Kordinator Kecamatan : {{ $data['korcam'] }}
                                </h6>
                                <hr>
                            @endif

                            <h6 style="margin-bottom: 10px;margin-top: 10px;">
                                Pendamping :
                                {{ $data['pendamping'] }}
                            </h6>

                            <ul class="list-group w-100">
                                @foreach ($data['desa_kpm'] as $index => $desa)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $desa['desa'] }}
                                        <span class="badge bg-primary rounded-pill">{{ count($desa['kpm']) }}</span>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    @endforeach
                @endforeach
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".kecamatan-filter").change(function() {
                var kecamatan = $(this).val();

                if ($(this).prop("checked")) {
                    $(".kecamatan-" + kecamatan).show();
                } else {
                    $(".kecamatan-" + kecamatan).hide();
                }
            });
        });
    </script>
@endsection