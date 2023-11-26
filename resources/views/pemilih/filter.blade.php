@extends('layouts.main')

@section('content')
    <div id="app">
        

        <main>
            <div class="container mt-4">
                <h2 class="text-lg font-bold mb-2">Sumber</h2>

                <div class="card-deck">

                    <!-- Kartu pertama -->
                    @foreach ($pemilih as $data)
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $data->sumber }}</h5>
                                <p class="card-text">
                                    <a href="{{ route('filter.korkab', $data->korkab) }}">
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
