<?php

namespace App\Admin\Repositories;

use App\Models\Powerprovince as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Powerprovince extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
