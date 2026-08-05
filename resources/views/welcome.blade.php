@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h1 class="h3 mb-3">INEGI Estados</h1>
                            <p class="text-body-secondary mb-4">
                                Proyecto con Laravel, MySQL, Bootstrap y Vite.
                            </p>

                            <h2 class="h5">Comandos</h2>
                            <pre class="bg-light border rounded p-3 mb-4"><code>npm run dev
php artisan serve
php artisan migrate</code></pre>

                            <h2 class="h5">Build para servidor</h2>
                            <pre class="bg-light border rounded p-3 mb-0"><code>npm run build</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
