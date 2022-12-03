<?php

namespace App\Repositories;

use App\Filters\QueryFilters;

/**
 *
 */
interface RepositoryInterface
{
    /**
     * @return mixed|\Illuminate\Support\Collection
     */
    public function all();

    /**
     *
     * @param  int|\Closure|null  $perPage
     * @param  array|string  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate(
        int|\Closure $perPage = null,
        array|string $columns = ['*'],
        string $pageName = 'page',
        int $page = null
    );

    /**
     *
     * @param  \App\Filters\QueryFilters  $filters
     * @param  int|\Closure|null  $perPage
     * @param  array|string  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginateWithFilters(
        QueryFilters $filters,
        int|\Closure $perPage = null,
        array|string $columns = ['*'],
        string $pageName = 'page',
        int $page = null
    );

    /**
     * @param  array  $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param  array  $attributes
     * @param  array  $options
     * @param $id
     * @return bool|int
     */
    public function update(array $attributes, $id, array $options = []);

    /**
     * @param $id
     * @return bool|int
     */
    public function delete($id);
}
