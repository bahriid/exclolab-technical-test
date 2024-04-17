<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id): Model|Collection|Builder|array|null
    {
        return User::query()->findOrFail($id);
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findBy($key, $columns = '*', $relations = null): Model|Collection|Builder|array|null
    {
        return User::query()
            ->when($relations, fn($q) => $q->with($relations))
            ->select($columns)
            ->where($key)
            ->first();
    }

    /**
     * @return Collection|array
     */
    public function get(): Collection|array
    {
        return User::query()->get();

    }

    /**
     * @param $attributes
     * @return Builder|Model
     */
    public function create($attributes)
    {
        return User::query()->create($attributes);
    }

    /**
     * @param $attributes
     * @return bool|int
     */
    public function update($id, $attributes)
    {
        return User::query()->find($id)->update($attributes);
    }

}
