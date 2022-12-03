<?php

namespace App\Repositories\Eloquent;

use App\Filters\QueryFilters;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * @param  Model|Builder  $entity
     */
    public function __construct(protected Model|Builder $entity)
    {
        //
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->entity->get();
    }

    /**
     * @param  int|\Closure|null  $perPage
     * @return mixed
     */
    public function paginate(int|\Closure $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->entity->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * @param  int|\Closure|null  $perPage
     * @return mixed
     */
    public function paginateWithFilters(
        QueryFilters $filters,
        int|\Closure $perPage = null,
        $columns = ['*'],
        $pageName = 'page',
        $page = null
    ) {
        return $this->entity->filter($filters)->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * @param  array  $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->entity->create($attributes);
    }

    /**
     * @param $id
     * @param  array|string  $columns
     * @return mixed
     */
    public function find($id, array|string $columns = ['*'])
    {
        return $this->entity->find($id, $columns);
    }

    /**
     * @param  array  $attributes
     * @param    $id
     * @param  array  $options
     * @return bool|int
     */
    public function update(array $attributes, $id, array $options = [])
    {
        return $this->entity->findOrFail($id)->update($attributes, $options);
    }

    /**
     * @param $id
     * @return bool|int
     */
    public function delete($id)
    {
        return $this->entity->findOrFail($id)->delete();
    }
}
