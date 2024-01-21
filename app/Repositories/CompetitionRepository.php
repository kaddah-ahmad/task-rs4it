<?php

namespace App\Repositories;

use App\Models\Competition;
use App\Ports\ICompetitionRepository;
use Illuminate\Database\Eloquent\Model;

class CompetitionRepository extends BaseRepository implements ICompetitionRepository
{

    protected $model;

    public function __construct(Competition $model)
    {
        $this->model = $model;
    }
}