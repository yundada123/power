<?php

namespace App\Admin\Repositories;

use App\Models\Orderchai as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Orderchai extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
