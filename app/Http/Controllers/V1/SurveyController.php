<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Surveys\SurveyService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Survey\SurveyResource;
use App\Http\Resources\Survey\SurveyCollection;
use App\Traits\ResponseTrait;
use App\Http\Requests\Survey\SurveyRequest;
use App\Http\Requests\Survey\SurveyAnswerRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\SurveyForm;

class SurveyController extends Controller
{
    use ResponseTrait;

    protected $surveryService;

    public function __construct(SurveyService $surveryService)
    {
        $this->surveryService = $surveryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $survey = $this->surveryService->getForms();

        return (new SurveyCollection($survey));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SurveyRequest $request)
    {
        DB::beginTransaction();
        try {
            $survey = $this->surveryService->createForm($request->toArray());

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
        }

        return (new SurveyResource($survey));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $survey = $this->surveryService->getForm($id);

        return (new SurveyResource($survey));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function submitAnswer(SurveyAnswerRequest $request)
    {
        DB::beginTransaction();
        try {
            $surveys = $this->surveryService->getForm($request['survey_id']);

            $this->surveryService->answerForm($request->toArray());

            Mail::to(auth()->user()->email)->queue(new SurveyForm($surveys['title']));

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();

            return $this->renderException($ex);
        }

        return (new SurveyResource(null))->additional([
            'message' => 'Successfully submit the form.',
        ]);
    }
}
