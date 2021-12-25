<?php

namespace App\Http\Controllers;

use DB;
use Throwable;
use App\Models\Lead;
use App\Http\Requests\Lead as LeadRequest;
use App\Helpers\HttpStatus as Status;
use App\Services\ActiveCampaignService;
use App\Http\Resources\Lead as LeadResource;

class LeadController extends Controller
{
    /**
     * Lead instance.
     *
     * @var \App\Models\Lead
     */
    protected $lead;

    /**
     * ActiveCampaignService instance.
     *
     * @var \App\Services\ActiveCampaignService
     */
    protected $service;
  
    /**
     * Create a new controller instance.
     * 
     * @param \App\Models\Lead  $lead
     * @param \App\Services\ActiveCampaignService  $service
     */
    public function __construct(Lead $lead, ActiveCampaignService $service)
    {
        $this->lead = $lead;

        $this->service = $service;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            return response()->api([
                'data' => LeadResource::collection($this->lead->all()),
            ], Status::OK);
        } catch (Throwable $t) {
            $this->logError($t);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     * 
     * @param  \App\Http\Requests\Lead  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LeadRequest $request)
    {
        $session = DB::getMongoClient()->startSession();

        $session->startTransaction();

        try {
            $lead = $this->lead->create($request->all());

            if (!empty($lead)) {
                $this->service->syncContact($lead, $request->list_id);

                $session->commitTransaction();

                return response()->api([
                    'data' => new LeadResource($lead),
                ], Status::CREATED);
            }
        } catch (Throwable $t) {
            $session->abortTransaction();

            $this->logError($t);
        }
    }

    /**
     * Display the specified resource.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     * 
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Lead $lead)
    {
        try {
            return response()->api([
                'data' => new LeadResource($lead),
            ], Status::OK);
        } catch (Throwable $t) {
            $this->logError($t);
        }        
    }

    /**
     * Update the specified resource in storage.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     * 
     * @param  \App\Http\Requests\Lead  $request
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LeadRequest $request, Lead $lead)
    {
        $session = DB::getMongoClient()->startSession();

        $session->startTransaction();

        try {
            $lead->update($request->all());

            $this->service->syncContact($lead, $request->list_id);

            $session->commitTransaction();

            return response()->api([
                'data' => new LeadResource($lead),
            ], Status::OK);
        } catch (Throwable $t) {
            $session->abortTransaction();

            $this->logError($t);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     * 
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Lead $lead)
    {
        try {
            // $this->service->deleteContact($lead);            

            return response()->api([
                'data' => new LeadResource(tap($lead)->delete()),
            ], Status::OK);
        } catch (Throwable $t) {
            $this->logError($t);
        }
    }
}
