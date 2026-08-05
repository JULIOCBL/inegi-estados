<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Services\InegiService;
use App\Support\StateQueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class StateController extends Controller
{
    public function index(): View
    {
        return view('states.index', [
            'states' => State::query()
                ->orderBy('code')
                ->get(),
        ]);
    }

    public function paginated(Request $request): View
    {
        $state_query = StateQueryBuilder::forRequest($request);

        return view('states.paginated', [
            'states' => $state_query->paginate((int) $request->integer('per_page', 10)),
            'filters' => [
                'search' => $request->string('search')->toString(),
                'sort_by' => $request->string('sort_by')->toString() ?: 'code',
                'sort_direction' => $request->string('sort_direction')->toString() ?: 'asc',
                'per_page' => (int) $request->integer('per_page', 10),
            ],
        ]);
    }

    public function import(InegiService $inegi_service): RedirectResponse
    {
        try {
            $timestamp = now();
            $states = collect($inegi_service->fetchStates())
                ->map(fn (array $state) => [
                    ...$state,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ])
                ->all();

            if ($states === []) {
                return back()->with('error', 'El servicio de INEGI no devolvió estados.');
            }

            State::query()->upsert(
                $states,
                ['code'],
                ['geo_code', 'name', 'short_name', 'population', 'female_population', 'male_population', 'inhabited_homes', 'updated_at']
            );

            return back()->with('success', 'Los estados se importaron correctamente.');
        } catch (Throwable $exception) {
            report($exception);

            return back()->with('error', 'No fue posible importar los estados en este momento.');
        }
    }

    public function municipalities(State $state, InegiService $inegi_service): View|RedirectResponse
    {
        try {
            $municipalities = $inegi_service->fetchMunicipalities($state->code);
            $previous_url = url()->previous();
            $back_url = str_contains($previous_url, '/states')
                && $previous_url !== url()->current()
                ? $previous_url
                : route('states.index');

            return view('states.municipalities', [
                'state' => $state,
                'municipalities' => $municipalities,
                'back_url' => $back_url,
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('states.index')
                ->with('error', 'No fue posible cargar los municipios en este momento.');
        }
    }
}
