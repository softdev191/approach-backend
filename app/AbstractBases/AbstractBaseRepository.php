<?php

namespace App\AbstractBases;

use App\Models\Model;

class AbstractBaseRepository {

    protected $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function instance(): Model {
        return $this->model;
    }

    public function find($field, $value) {
        return $this->model->where($field, $value)->first();
    }

    public function findAll($field, $value) {
        return $this->model->where($field, $value)->get();
    }

    public function insert($data) {
        return $this->model->insert($data);
    }

    public function create(array $data) {
        return $this->model->create($data);
    }


    public function update(Model $context, array $data) {
        return $context->update($data);
    }

    public function delete(Model $context) {
        return $context->delete();
    }

    public function deleteItems(array $items) {
        return $this->model->whereIn('uuid', $items)->delete();
    }

    public function deleteByField($field, $value) {
        return $this->model->where($field, $value)->delete();
    }

    public function applyFilters(array $filters, $query)
    {
        if (empty($filters)) {
            return $query;
        }

        $query->where(function ($query2) use ($filters, $query) {
            if (isset($filters['where'])) {
                foreach ($filters['where'] as $column => $value) {
                    $query2->where($column, $value);
                }
            }
        });

        $query->where(function ($query3) use ($filters, $query) {
            if (isset($filters['orWhere'])) {
                foreach ($filters['orWhere'] as $column => $value) {
                    $query3->orWhere($column, 'LIKE', '%' . $value . '%');
                }
            }
        });

        return $query;
    }

    public function getAll()
    {
        return $this->model->get();
    }
}
