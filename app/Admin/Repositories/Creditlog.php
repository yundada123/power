<?php

namespace App\Admin\Repositories;

use App\Models\Creditlog as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Creditlog extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
