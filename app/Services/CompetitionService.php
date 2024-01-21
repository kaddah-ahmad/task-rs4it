<?php

namespace App\Services;

use App\Dto\CraeteCompetitionDto;
use App\Exceptions\CompetitionNotFoundException;
use App\Exceptions\InternalServerErrorException;
use App\Repositories\CompetitionRepository;

class CompetitionService
{
    private $repository;

    public function __construct(CompetitionRepository $competitionRepository)
    {
        $this->repository = $competitionRepository;
    }

    public function createCompetition(CraeteCompetitionDto $craeteCompetitionDto)
    {
        return $this->repository->create([
            'title' => $craeteCompetitionDto->title,
            'description' => $craeteCompetitionDto->description,
            'image' => $craeteCompetitionDto->image,
        ]);
    }

    public function getCompetition($id)
    {
        $competition = $this->repository->findById($id);

        if (!$competition) {
            throw new CompetitionNotFoundException();
        }

        return $competition;
    }

    public function getCompetitions()
    {
        return $this->repository->all();
    }

    public function updateCompetition($id, array $attributes = [])
    {
        $competition = $this->repository->findById($id);

        if (!$competition) {
            throw new CompetitionNotFoundException();
        }

        $result = $this->repository->update($id, $attributes);

        if (!$result) {
            throw new InternalServerErrorException();
        }

        return $result;
    }

    public function deleteCompetition($id)
    {
        $competition = $this->repository->findById($id);

        if (!$competition) {
            throw new CompetitionNotFoundException();
        }

        $result = $this->repository->delete($id);

        if (!$result) {
            throw new InternalServerErrorException();
        }

        return $result;
    }
}
