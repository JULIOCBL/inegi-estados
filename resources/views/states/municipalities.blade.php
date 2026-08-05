@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    <section class="py-4">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h1 class="h3 mb-1">Municipios</h1>
                    <p class="text-body-secondary mb-0">{{ $state->name }} ({{ $state->code }})</p>
                </div>

                <a href="{{ $back_url }}" class="btn btn-outline-secondary">
                    Regresar
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    @if ($municipalities === [])
                        <p class="mb-0 text-body-secondary">No se encontraron municipios para este estado.</p>
                    @else
                        <div class="table-responsive">
                            <table id="municipalities-table" class="table table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Clave</th>
                                        <th>Municipio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($municipalities as $municipality)
                                        <tr>
                                            <td>{{ $municipality['code'] }}</td>
                                            <td>{{ $municipality['name'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
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
    @vite('resources/js/views/states-municipalities.js')
@endpush
