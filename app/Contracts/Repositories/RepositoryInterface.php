<?php


namespace App\Contracts\Repositories;


use Illuminate\Database\Eloquent\Builder;

interface RepositoryInterface
{
    /**
     * @param array $with
     * @return $this
     */
    public function with(array $with):static;

    /**
     * @return Builder
     */
    public function model(): Builder;
}
