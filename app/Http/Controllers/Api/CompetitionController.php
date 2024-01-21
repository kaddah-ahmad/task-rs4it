<?php

namespace App\Http\Controllers\Api;

use App\Dto\CraeteCompetitionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompetitionRequest;
use App\Http\Resources\CompetionCollection;
use App\Http\Resources\CompetionResource;
use App\Services\CompetitionService;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    protected $service;

    public function __construct(CompetitionService $competitionService)
    {
        $this->service = $competitionService;
    }

    public function createCompetition(CreateCompetitionRequest $request)
    {
        $createCompetitionDto = new CraeteCompetitionDto(
            $request->input('title'),
            $request->input('description'),
            $request->input('image')
        );

        $competition = $this->service->createCompetition($createCompetitionDto);

        return response()->json([
            'success' => true,
            'message' => 'Competion Created Successfully',
            'competition' => new CompetionResource($competition),
        ]);
    }

    public function getCompetitionById($id)
    {
        $competition = $this->service->getCompetition($id);

        return response()->json([
            "success" => true,
            "message" => "fetched comprtion successfully",
            "result" => new CompetionResource($competition),
        ], 200);
    }

    public function getCompetitions()
    {
        $competitions = $this->service->getCompetitions();

        return response()->json([
            'success' => true,
            'message' => 'get competitions successfully',
            'competions' => new CompetionCollection($competitions),
        ], 200);
    }

    public function updateCompetition(Request $request, $id)
    {
        $inputs = [];
        (isset($request->title) && $request->title !== null) ? $inputs['title'] = $request->title : null;
        (isset($request->description) && $request->description !== null) ? $inputs['description'] = $request->description : null;
        (isset($request->image) && $request->image !== null) ? $inputs['image'] = $request->image : null;

        $this->service->updateCompetition($id, $inputs);

        return response()->json([
            "success" => true,
            "message" => "updating competion successfully",
        ], 200);
    }

    public function deleteCompetition($id)
    {
        $this->service->deleteCompetition($id);

        return response()->json([
            "success" => true,
            "message" => "deleting competion successfully",
        ], 200);
    }
}
