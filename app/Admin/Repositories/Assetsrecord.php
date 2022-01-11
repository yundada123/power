<?php

namespace App\Admin\Repositories;

use App\Models\Assetsrecord as Model;
use Dcat\Admin\Contracts\Repository;
use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\EloquentRepository;

class Assetsrecord extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
   
}
