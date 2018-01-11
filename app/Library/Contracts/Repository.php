<?php

namespace StreetWorks\Library\Contracts;

/**
 * Interface Repository
 * @package StreetWorks\Library\Contracts
 */
interface Repository
{
    /**
     * Retrieve a model.
     *
     * @return mixed
     */
    public function retrieve();

    /**
     * Create a model.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes = []);

    /**
     * Delete a model.
     *
     * @return mixed
     */
    public function delete();

    /**
     * Update a model.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function update($attributes = []);
}