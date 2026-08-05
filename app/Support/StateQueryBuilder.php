<?php

namespace App\Support;

use App\Models\State;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StateQueryBuilder
{
    public function __construct(
        private readonly Builder $query,
    ) {
    }

    public static function forRequest(Request $request): self
    {
        $builder = new self(State::query());

        return $builder
            ->applySearch($request->string('search')->toString())
            ->applySorting(
                $request->string('sort_by')->toString(),
                $request->string('sort_direction')->toString()
            );
    }

    public function applySearch(?string $search): self
    {
        $search = trim((string) $search);

        if ($search === '') {
            return $this;
        }

        $this->query->where(function (Builder $query) use ($search): void {
            $query
                ->where('code', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('short_name', 'like', '%' . $search . '%');
        });

        return $this;
    }

    public function applySorting(?string $sort_by, ?string $sort_direction): self
    {
        $allowed_columns = [
            'code',
            'name',
            'population',
            'short_name',
        ];

        $sort_by = in_array($sort_by, $allowed_columns, true) ? $sort_by : 'code';
        $sort_direction = $sort_direction === 'desc' ? 'desc' : 'asc';

        $this->query->orderBy($sort_by, $sort_direction);

        return $this;
    }

    public function get()
    {
        return $this->query->get();
    }

    public function paginate(int $per_page = 10)
    {
        return $this->query->paginate($per_page)->withQueryString();
    }
}
