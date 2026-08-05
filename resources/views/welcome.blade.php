@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="border rounded-4 bg-white shadow-sm overflow-hidden">
                        <div class="p-4 p-md-5 border-bottom">
                            <p class="text-uppercase text-secondary small fw-semibold mb-2">Módulo principal</p>
                            <h1 class="display-6 fw-semibold mb-3">Consulta de estados</h1>
                            <p class="text-body-secondary mb-0">
                                Elige la forma en que quieres revisar el catálogo cargado desde INEGI.
                            </p>
                        </div>

                        <div class="p-4 p-md-5">
                            <div class="list-group list-group-flush">
                                <a
                                    href="{{ route('states.index') }}"
                                    class="list-group-item list-group-item-action px-0 py-4 border-top-0"
                                >
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                        <div>
                                            <h2 class="h5 mb-2">Listado con DataTable</h2>
                                            <p class="text-body-secondary mb-2">
                                                Búsqueda, ordenamiento y paginación desde el navegador.
                                            </p>
                                            <small class="text-secondary">Recomendado para consulta rápida</small>
                                        </div>
                                        <span class="btn btn-primary px-4">Entrar</span>
                                    </div>
                                </a>

                                <a
                                    href="{{ route('states.paginated') }}"
                                    class="list-group-item list-group-item-action px-0 py-4"
                                >
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                        <div>
                                            <h2 class="h5 mb-2">Listado con paginación Laravel</h2>
                                            <p class="text-body-secondary mb-2">
                                                Filtros y ordenamiento resueltos desde el servidor.
                                            </p>
                                            <small class="text-secondary">Útil para no cargar toda la información de una sola vez</small>
                                        </div>
                                        <span class="btn btn-outline-dark px-4">Entrar</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
