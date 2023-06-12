<?php

interface EntityInterface
{
    public function getUuId(): string;
    public function setUuId(string $id): void;
    public function toArray()
}