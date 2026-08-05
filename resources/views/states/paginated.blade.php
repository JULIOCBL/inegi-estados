@extends('layouts.app')

@section('content')
    <section class="py-4">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h1 class="h3 mb-1">Estados</h1>
                    <p class="text-body-secondary mb-0">Consulta el listado con filtros y paginación desde Laravel.</p>
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

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('states.paginated') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Buscar</label>
                            <input
                                id="search"
                                name="search"
                                type="text"
                                value="{{ $filters['search'] }}"
                                class="form-control"
                                placeholder="Clave o nombre"
                            >
                        </div>

                        <div class="col-md-3">
                            <label for="sort_by" class="form-label">Ordenar por</label>
                            <select id="sort_by" name="sort_by" class="form-select">
                                <option value="code" @selected($filters['sort_by'] === 'code')>Clave</option>
                                <option value="name" @selected($filters['sort_by'] === 'name')>Estado</option>
                                <option value="population" @selected($filters['sort_by'] === 'population')>Población</option>
                                <option value="short_name" @selected($filters['sort_by'] === 'short_name')>Abreviatura</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="sort_direction" class="form-label">Dirección</label>
                            <select id="sort_direction" name="sort_direction" class="form-select">
                                <option value="asc" @selected($filters['sort_direction'] === 'asc')>Ascendente</option>
                                <option value="desc" @selected($filters['sort_direction'] === 'desc')>Descendente</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="per_page" class="form-label">Por página</label>
                            <select id="per_page" name="per_page" class="form-select">
                                <option value="10" @selected($filters['per_page'] === 10)>10</option>
                                <option value="25" @selected($filters['per_page'] === 25)>25</option>
                                <option value="50" @selected($filters['per_page'] === 50)>50</option>
                            </select>
                        </div>

                        <div class="col-md-1 d-grid">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="states-paginated-table" class="table table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Estado</th>
                                    <th>Población</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($states as $state)
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
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-body-secondary">No se encontraron estados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $states->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('vite')
    @vite('resources/js/views/states-paginated.js')
@endpush
