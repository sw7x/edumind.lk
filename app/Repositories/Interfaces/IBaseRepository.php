<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


interface IBaseRepository extends IRepository{

    public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model;

    public function findManyByIds(array $modelIds = [], array $columns = ['*'], array $relations = [], array $appends = []): ?Collection;

    public function findTrashedById(int $modelId): ?Model;

    public function findOnlyTrashedById(int $modelId): ?Model;

    public function deleteById(int $modelId): bool;

    public function restoreById(int $modelId): bool;

    public function permanentlyDeleteById(int $modelId): bool;
}
