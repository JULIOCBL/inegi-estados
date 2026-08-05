@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    <section class="py-4">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h1 class="h3 mb-1">Estados</h1>
                    <p class="text-body-secondary mb-0">Importa y consulta las 32 entidades federativas del INEGI.</p>
                </div>

                <form action="{{ route('states.import') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Importar estados
                    </button>
                </form>
            </div>

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

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="states-table" class="table table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Estado</th>
                                    <th>Población</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($states as $state)
                                    <tr>
                                        <td>{{ $state->code }}</td>
                                        <td>
                                            <a href="{{ route('states.municipalities', $state) }}" class="text-decoration-none">
                                                {{ $state->name }}
                                            </a>
                                        </td>
                                        <td data-order="{{ $state->population }}">
                                            {{ number_format($state->population) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
@endpush

@push('vite')
    @vite('resources/js/views/states-index.js')
@endpush
