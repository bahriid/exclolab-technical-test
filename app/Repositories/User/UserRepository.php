<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository
{
    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findById($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return User::query()->findOrFail($id);
    }
    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findBy($key, $columns = '*', $relations = null): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return User::query()
            ->when($relations, fn($q)=> $q->with($relations))
            ->select($columns)
            ->where($key)
            ->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function get(): \Illuminate\Database\Eloquent\Collection|array
    {
        return User::query()->get();

    }

}
