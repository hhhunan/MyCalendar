<?php

namespace App\Repositories;

use App\Contracts\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Repository
 * @package App\Repositories
 */
abstract class Repository implements RepositoryInterface
{
    protected array $with;

    /**
     * @return string
     */
    abstract protected function getModelClassName(): string;

    /**
     * @param array $with
     * @return $this
     */
    public function with(array $with): static
    {
        $this->with = $with;
        return $this;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    protected function prepareQuery(Builder $query): Builder
    {
        if ($this->with) {
            $query->with($this->with);
        }

        return $query;
    }

    /**
     * @return Builder
     */
    final public function model(): Builder
    {
        $className = $this->getModelClassName();

        return $this->prepareQuery($className::query());
    }
}
