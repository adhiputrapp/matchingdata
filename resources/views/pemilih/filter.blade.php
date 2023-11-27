@extends('layouts.main')

@section('content')
    <div id="app">


        <main>
            <div class="container mt-4">
                <h2 class="text-lg font-bold mb-2">Pilih Sumber</h2>

                <div class="card-deck">

                    <!-- Kartu pertama -->
                    @foreach ($pemilih as $data)
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $data->sumber }}</h5>
                                <p class="card-text">
                                    <a href="{{ route('filter.sumber', ['sumber' => $data->sumber]) }}"
                                        class="inline-block rounded bg-danger px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(220,76,100,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)]">
                                        Detail
                                    </a>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </main>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom Script for Filter and Limit -->
@endsection
