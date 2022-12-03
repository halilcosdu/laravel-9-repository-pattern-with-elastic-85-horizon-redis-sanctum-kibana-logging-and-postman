<?php

namespace App\Observers;

/**
 * Repository Pattern Example Class.
 */
class UserObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle "created" event.
     *
     * @param $model
     * @return void
     */
    public function created($model)
    {
        //
    }

    /**
     * Handle "updated" event.
     *
     * @param $model
     * @return void
     */
    public function updated($model)
    {
        //
    }

    /**
     * Handle "deleted" event.
     *
     * @param $model
     * @return void
     */
    public function deleted($model)
    {
        //
    }

    /**
     * Handle "restored" event.
     *
     * @param $model
     * @return void
     */
    public function restored($model)
    {
        //
    }

    /**
     * Handle "forceDeleted" event.
     *
     * @param $model
     * @return void
     */
    public function forceDeleted($model)
    {
        //
    }
}
