<?php


namespace App\Repositories\Eloquent;


use App\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var $model Model
     */

    private $model;

    protected function setModel($model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * @inheritDoc
     */
    public function find($id)
    {
        return $this->model::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function getAll(): Collection
    {
        return $this->model::all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data = []): Model
    {
        return $this->model::create($data);
    }
}
