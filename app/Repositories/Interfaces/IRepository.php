<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    //public function __construct(Model $model);

    public function all(array $columns = ['*'], array $relations = []): Collection;

    public function allTrashed(): Collection;



    public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model;

    public function findManyByIds(array $modelIds = [], array $columns = ['*'], array $relations = [], array $appends = []): ?Collection;

    public function findTrashedById(int $modelId): ?Model;

    public function findOnlyTrashedById(int $modelId): ?Model;

    public function deleteById(int $modelId): bool;

    public function restoreById(int $modelId): bool;

    public function permanentlyDeleteById(int $modelId): bool;



    public function create(array $payload, bool $updateTimestamps = true): ?Model;      

    public function update(int $modelId, array $payload, bool $updateTimestamps = true): bool;

}

