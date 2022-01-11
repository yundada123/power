<?php

namespace App\Admin\Repositories;

use App\Models\Phoneorder as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Phoneorder extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
