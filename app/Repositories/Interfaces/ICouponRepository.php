<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
//use App\Repositories\Interfaces\IRepository;


interface ICouponRepository{
    
    public function findByCode(string $modelCode, array $columns = ['*'], array $relations = [], array $appends = []): ?Model;

    public function findManyByCodes(array $modelIds = [], array $columns = ['*'], array $relations = [], array $appends = []): ?Collection;

    public function findTrashedByCode(string $modelId): ?Model;

    public function findOnlyTrashedByCode(string $modelId): ?Model;
    
    public function deleteByCode(string $modelId): bool;

    public function restoreByCode(string $modelId): bool;

    public function permanentlyDeleteByCode(string $modelId): bool;

    public function all(array $columns = ['*'], array $relations = []): Collection;

    public function allTrashed(): Collection;

    public function create(array $payload, bool $updateTimestamps = true): ?Model;      

    public function update(string $modelCode, array $payload, bool $updateTimestamps = true): bool;    

}