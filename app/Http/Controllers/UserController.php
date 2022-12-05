<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\UserContract;
use App\Filters\UserFilters;
use App\Http\Requests\User\DestroyRequest;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\ShowRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;

/**
 *
 */
class UserController extends Controller
{
    /**
     * @param  \App\Contracts\Repositories\UserContract  $userContract
     */
    public function __construct(private readonly UserContract $userContract)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request, UserFilters $filters)
    {
        dd($request->all());

        activity([
            'action' => 'users.index',
        ]);

        return $this->response()->success(
            UserResource::collection($this->userContract->paginateWithFilters($filters, $request->per_page))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        activity([
            'action' => 'users.store',
        ]);

        return $this->response()->success(
            new UserResource($this->userContract->create($request->validated()))
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Requests\User\ShowRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowRequest $request, int $id)
    {
        activity([
            'action' => 'users.show',
        ]);

        return $this->response()->success(
            new UserResource($this->userContract->find($id))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, int $id)
    {
        activity([
            'action' => 'users.update',
        ]);

        $this->userContract->update($request->validated(), $id);

        return $this->response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\User\DestroyRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequest $request, int $id)
    {
        activity([
            'action' => 'users.destroy',
        ]);

        $this->userContract->delete($id);

        return $this->response()->noContent();
    }
}
