@extends('layouts.main')

@section('content')
    <div id="app">
       
        <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input 
            class="relative mb-2 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
            type="file" name="file" required>
            <button
            class="mb-3 inline-block w-full rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_rgba(0,0,0,0.2)] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:outline-none focus:ring-0 active:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)]"
            type="button"
            data-te-ripple-init
            data-te-ripple-color="light"
            style="
              background: linear-gradient(to bottom left, #000000, #d8363a);
            ">
            Import
        </button>
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
            <table class="min-w-full border-black border-2 text-left text-sm font-light">
                <thead class=" font-medium dark:border-neutral-500">
                    <tr>
                        
                        <th scope="col" class="px-6 py-4 text-lg font-bold border-black border-2">Kecamatan</th>
                        <th scope="col" class="px-6 py-4 text-lg font-bold border-black border-2">Korcam</th>
                        <th scope="col" class="px-6 py-4 text-lg font-bold border-black border-2">Pendamping</th>
                        <th scope="col" class="px-6 py-4 text-lg font-bold border-black border-2">Desa</th>
                        <th scope="col" class="px-6 py-4 text-lg font-bold border-black border-2">KPM</th>

                        <th scope="col" class="px-6 py-4 text-lg font-bold border-black border-2">TPS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td class="px-6 py-4 border-black border-2 text-2xl font-bold items-center" colspan="7" style="background: yellow;">Korkab : {{ $result->korkab }}</td>
                        </tr>
                        @foreach (json_decode($result->result, true) as $data)
                            @foreach ($data['desa_kpm'] as $index => $desa)
                                <tr>
                                    @if ($index === 0)
                                        {{-- <td class="px-6 py-4 border-b border"rowspan="{{ count($data['desa_kpm']) }}"></td> --}}
                                        <td class="px-6 py-4  text-md font-bold border-black border-2"rowspan="{{ count($data['desa_kpm']) }}">{{ $data['Kecamatan'] }}</td>
                                        <td class="px-6 py-4  text-md font-bold border-black border-2"rowspan="{{ count($data['desa_kpm']) }}">{{ $data['korcam'] }}</td>
                                        <td class="px-6 py-4  text-md font-bold border-black border-2"rowspan="{{ count($data['desa_kpm']) }}">{{ $data['pendamping'] }}</td>
                                    @endif
                                    <td class="px-6 py-4  text-md font-bold border-black border-2">{{ $desa['desa'] }}</td>
                                    <td class="px-6 py-4  text-md font-bold border-black border-2">{{ count($desa['kpm']) }}</td>
                                    <td class="px-6 py-4  text-md font-bold border-black border-2">{{ $desa['tps'] }}</td>
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
@endsection