<?php

namespace Moltox\ColumnMultiFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Moltox\ColumnMultiFilter\Classes\Filter;
use Moltox\ColumnMultiFilter\Exceptions\ColumnMultiFilterException;

trait ColumnMultiFilter
{


    /**
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeMultiFilter(Builder $query): Builder
    {

        if (request()->has('filter')) {

            $filters = request()->get('filter');

            $this->log('Filter found: ' . print_r($filters, true));

            return $this->filterQueryBuilder($query, $filters);

        }

        return $query;

    }

    protected function filterQueryBuilder(Builder $query, array $filters)
    {

        foreach ($filters as $column => $value) {

            if ($this->isColumnFilterable($column)) {

                $this->log(sprintf('Filterable column found: %30s  with value: %s', $column, $value));

                $filterType = $this->getFilterType($column);
                $logic = $this->getLogic($column);
                $operator = $this->getOperator($filterType);
                $value = trim($value);

                $this->addFilter($query, $column, $operator, $value, $logic);

            }
        }

        return $query;

    }

    protected function isColumnFilterable(string $column)
    {

        return Arr::has($this->multiFilter, $column);

    }

    protected function getFilterType($column)
    {

        $type = config('column-multi-filter.default.type', Filter::LIKE);

        if (Arr::has($this->multiFilter[$column], 'type')) {

            $type = $this->multiFilter[$column]['type'];

        }

        return $type;

    }


    /**
     *
     * Returns the where logic for the given column
     *
     * @param $column
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected function getLogic($column)
    {

        $logic = config('column-multi-filter.default.logic', Filter::LIKE);

        if (Arr::has($this->multiFilter[$column], 'logic')) {

            $logic = $this->multiFilter[$column]['logic'];

        }

        return $logic;

    }

    protected function getOperator($type)
    {

        return match ($type) {
            Filter::LIKE => "like",
            default => "=",
        };

    }

    /**
     *
     * @throws ColumnMultiFilterException
     */
    protected function addFilter(Builder $query, string $column, string $operator, mixed $value, mixed $logic)
    {

        if ($this->isColumnRelational($column)) {

            $exp = explode(config('column-multi-filter.seperator', '.'), $column);

            if (count($exp) > 2) {
                throw new ColumnMultiFilterException($column, 3);
            } else {

                if (count($exp) === 2) {

                    list ($relation, $column) = $exp;


                    $query->whereHas(Str::camel($relation), function ($qb) use ($column, $operator, $value, $logic) {

                        /**
                         * @var Builder $qb
                         */
                        $qb = $this->addWhereIfValid($qb, $column, $operator, $value, $logic);
                    });

                }
            }

        } else {
            Log::debug('where ..'.print_r([$column, $operator, $value, $logic], true));
            $query = $this->addWhereIfValid($query, $column, $operator, $value, $logic);

        }

        return $query;

    }

    /**
     * @param  string  $column
     *
     * @return bool
     */
    private function isColumnRelational(string $column): bool
    {

        return count($this->splitRelatedColumn($column)) > 1;

    }

    private function splitRelatedColumn($relationColumn): array
    {

        return explode(config('column-multi-sort.uri_relation_column_separator', '.'), $relationColumn);

    }

    private function addWhereIfValid(Builder $query, string $column, string $operator, string $value, string $logic)
    {

        if (trim($operator) === 'like' && trim($value) === '') {
            return $query;
        }

        Log::debug('add where now');
        $query->where($column, $operator, $value, $logic);

        return $query;

    }


    private function log(string $message, $logLevel = 'info', $force = false)
    {

        if (config('column-multi-filter.log_enabled', false) || $force) {

            Log::channel(env('LOG_CHANNEL', 'stack'))->log($logLevel, '[MultiSort] '.$message);

        }

    }

}
