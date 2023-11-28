@extends('layouts.main')

@section('content')
    <div id="app">
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
                    $korcams2 = '';
                    $pendampings = '';
                    $pendampings2 = '';
                    $desas = '';
                    $desas2 = '';
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


                        @if ($korcams2 != $result->korcam)
                            @php $korcams2 = $result->korcam; @endphp
                            <h6>Kordinator Kecamatan : {{ $result->korcam }}
                            </h6>
                            <hr>
                        @endif

                        @if ($pendampings2 != $result->pendamping)
                            @php $pendampings2 = $result->pendamping; @endphp
                            <h6 style="margin-bottom: 10px;margin-top: 10px;">
                                Pendamping :

                                {{ $result->pendamping }}


                            </h6>
                        @endif

                        @if ($desas2 != $result->desa)
                            @php $desas2 = $result->desa; @endphp
                            <h6 style="margin-bottom: 10px;margin-top: 10px;">
                                Desa :

                                {{ $result->desa }}
                                <h6 style="margin-bottom: 10px;margin-top: 10px;">
                                    Total Per Desa :

                                    {{ $totalall[$desas2] }}
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
                        @foreach ($sama as $kunci => $hasil)
                            @if ($hasil->tps == $result->tps)
                                @if ($hasil->desa == $result->desa)
                                    <h6>Data yang Sama</h6>
                                    <div class="scrollable-list" style="max-height: 300px; overflow-y: auto;">
                                        <ul class="list-group w-100">
                                            @foreach (json_decode($result->kpm_array) as $index => $kpm)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $kpm }}
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    <p class="list-group-item d-flex justify-content-between align-items-center">
                                        Total per TPS : {{ count(json_decode($result->kpm_array)) }}
                                    </p>
                                @endif
                            @endif
                        @endforeach

                        @foreach ($tidaksama as $keys => $results)
                            @if ($results->tps == $result->tps)
                                @if ($results->desa == $result->desa)
                                    <h6>Data yang Berbeda</h6>
                                    <div class="scrollable-list" style="max-height: 300px; overflow-y: auto;">
                                        <ul class="list-group w-100">
                                            @foreach (json_decode($results->kpm_array) as $indexs => $kpms)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $kpms }}
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    <p class="list-group-item d-flex justify-content-between align-items-center">
                                        Total per TPS : {{ count(json_decode($results->kpm_array)) }}
                                    </p>
                                @endif
                            @endif
                        @endforeach
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
@endsection