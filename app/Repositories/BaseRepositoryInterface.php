<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /**
     * this method must return one record
     *
     * @param int $id
     * @return mixed
     */
    public function find($id);

    /**
     * this method must return all of records as an array
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * create new record
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data = []): Model;
}
