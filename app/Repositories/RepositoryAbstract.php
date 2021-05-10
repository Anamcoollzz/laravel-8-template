<?php

namespace App\Repositories;

abstract class RepositoryAbstract
{

    protected $model;

    /**
     * get all data
     *
     * @return Collection
     */
    abstract public function all();

    /**
     * get all data order by created at desc
     *
     * @return Collection
     */
    abstract function getLatest();

    /**
     * get all data order by created at desc
     *
     * @param string $column
     * @param string $method
     * @return Collection
     */
    abstract public function getOrderBy(string $column, string $method = 'asc');

    /**
     * store data to db
     *
     * @param array $data
     * @return Model
     */
    abstract public function create(array $data);

    /**
     * store data to db
     *
     * @param array $data
     * @return Model
     */
    abstract public function store(array $data);

    /**
     * find data by id
     *
     * @param int $id
     * @return Model
     */
    abstract public function find(int $id);

    /**
     * update data by id
     *
     * @param array $data
     * @param int $id
     * @return Model
     */
    abstract public function update(array $data, int $id);

    /**
     * delete data by id
     *
     * @param int $id
     * @return Model
     */
    abstract public function delete(int $id);

    /**
     * delete data by id
     *
     * @param int $id
     * @return Model
     */
    abstract public function destroy(int $id);
}
