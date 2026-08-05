<?php

namespace App\Services;

use Illuminate\Http\Client\Factory as HttpFactory;
use RuntimeException;
use Throwable;

/**
 * Encapsula la comunicación con los endpoints públicos del INEGI
 * para mantener la lógica HTTP fuera de los controladores.
 */
class InegiService
{
    public function __construct(
        private readonly HttpFactory $http,
    ) {
    }

    /**
     * Obtiene las entidades federativas desde INEGI y las transforma
     * al formato interno utilizado por la tabla states.
     *
     * @return array<int, array<string, int|string|null>>
     */
    public function fetchStates(): array
    {
        $records = $this->requestData('mgee/');

        return collect($records)
            ->map(function (array $record): ?array {
                $code = $record['cve_ent'] ?? null;
                $name = $record['nomgeo'] ?? null;
                $population = $record['pob_total'] ?? $record['total_pop'] ?? null;

                if (! $code || ! $name || $population === null) {
                    return null;
                }

                return [
                    'geo_code' => (string) ($record['cvegeo'] ?? $code),
                    'code' => (string) $code,
                    'name' => (string) $name,
                    'short_name' => isset($record['nom_abrev']) ? (string) $record['nom_abrev'] : null,
                    'population' => $this->normalizeInteger($population),
                    'female_population' => isset($record['pob_femenina']) ? $this->normalizeInteger($record['pob_femenina']) : null,
                    'male_population' => isset($record['pob_masculina']) ? $this->normalizeInteger($record['pob_masculina']) : null,
                    'inhabited_homes' => isset($record['total_viviendas_habitadas']) ? $this->normalizeInteger($record['total_viviendas_habitadas']) : null,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Obtiene los municipios de un estado sin persistirlos en base de datos.
     *
     * @param string $state_code Clave de la entidad federativa, por ejemplo "01".
     * @return array<int, array<string, string>>
     */
    public function fetchMunicipalities(string $state_code): array
    {
        $records = $this->requestData('mgem/' . $state_code);

        return collect($records)
            ->map(function (array $record): ?array {
                $code = $record['cve_mun'] ?? $record['cvegeo'] ?? null;
                $name = $record['nomgeo'] ?? null;

                if (! $code || ! $name) {
                    return null;
                }

                return [
                    'code' => (string) $code,
                    'name' => (string) $name,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Realiza una petición al servicio del INEGI y devuelve el arreglo
     * principal de registros usando la clave esperada del payload.
     *
     * @throws RuntimeException
     */
    private function requestData(string $path): array
    {
        try {
            $response = $this->http
                ->baseUrl(config('services.inegi.base_url'))
                ->acceptJson()
                ->get($path)
                ->throw();
        } catch (Throwable $exception) {
            throw new RuntimeException('Unable to connect to the INEGI service.', previous: $exception);
        }

        $payload = $response->json();
        $data = $payload['datos'] ?? $payload['data'] ?? null;

        if (! is_array($data)) {
            throw new RuntimeException('The INEGI service returned an unexpected response.');
        }

        return $data;
    }

    /**
     * Convierte valores numéricos con formato de texto a entero limpio.
     */
    private function normalizeInteger(string|int|float $value): int
    {
        return (int) preg_replace('/\D+/', '', (string) $value);
    }
}
