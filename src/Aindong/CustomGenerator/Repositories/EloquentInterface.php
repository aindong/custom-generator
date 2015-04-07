<?php
namespace Aindong\CustomGenerator\Repositories;

interface EloquentInterface {

    /**
     * All
     * Get all the record
     *
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Paginate
     * Get a set of record
     *
     * @param $no
     * @return mixed
     */
    public function paginate($no = 10, $columns = ['*']);

    /**
     * Find
     * Find a specific record using the id/primary key
     *
     * @param $id
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * Find By
     * Find a specific records using a property
     *
     * @param $id
     * @return mixed
     */
    public function findBy($field, $value, $operator = '=');

    /**
     * Find one by
     * Find only one record using property
     *
     * @param array $option
     * @return mixed
     */
    //public function findOneBy(array $options, $columns = ['*']);

    /**
     * Create
     * Create a new record
     *
     * @param $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update
     * Update a specific record
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete
     * Delete a record
     *
     * @param $id
     * @return mixed
     */
    public function delete($id);
}