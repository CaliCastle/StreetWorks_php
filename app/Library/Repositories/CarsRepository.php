<?php

namespace StreetWorks\Library\Repositories;

use StreetWorks\Models\Car;
use StreetWorks\Library\Contracts\Repository;

class CarsRepository implements Repository
{
    /**
     * Car instance.
     *
     * @var Car
     */
    private $car;

    /**
     * CarsRepository constructor.
     *
     * @param Car $car
     */
    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    public function retrieve()
    {
        // TODO: Implement retrieve() method.
    }

    public function create($attributes = [])
    {
        // TODO: Implement create() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function update($attributes = [])
    {
        // TODO: Implement update() method.
    }
}