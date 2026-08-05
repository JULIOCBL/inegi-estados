<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Services\InegiService;
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
                return back()->with('error', 'No states were returned by the INEGI service.');
            }

            State::query()->upsert(
                $states,
                ['code'],
                ['geo_code', 'name', 'short_name', 'population', 'female_population', 'male_population', 'inhabited_homes', 'updated_at']
            );

            return back()->with('success', 'States imported successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()->with('error', 'The states could not be imported right now.');
        }
    }

    public function municipalities(State $state, InegiService $inegi_service): View|RedirectResponse
    {
        try {
            $municipalities = $inegi_service->fetchMunicipalities($state->code);

            return view('states.municipalities', [
                'state' => $state,
                'municipalities' => $municipalities,
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('states.index')
                ->with('error', 'The municipalities could not be loaded right now.');
        }
    }
}
