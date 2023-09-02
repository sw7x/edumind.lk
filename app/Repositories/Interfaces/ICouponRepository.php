<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


use App\Repositories\Interfaces\IRepository;


interface ICouponRepository extends IRepository{
    
    public function findByCode(string $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model;

    public function findManyByCodes(array $modelIds = [], array $columns = ['*'], array $relations = [], array $appends = []): ?Collection;

    public function findTrashedByCode(string $modelId): ?Model;

    public function findOnlyTrashedByCode(string $modelId): ?Model;
    
    public function deleteByCode(string $modelId): bool;

    public function restoreByCode(string $modelId): bool;

    public function permanentlyDeleteByCode(string $modelId): bool;
}
