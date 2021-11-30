<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Lead;
use App\Helpers\HttpStatus as Status;
use App\Services\ActiveCampaignService;

class ListController extends Controller
{
    /**
     * Take elements up to the specified position.
     *
     * @var int
     */
    const SIZE = 1000;

    /**
     * ActiveCampaignService instance.
     *
     * @var \App\Services\ActiveCampaignService
     */
    protected $service;

    /**
     * Create a new controller instance.
     * 
     * @param \App\Services\ActiveCampaignService  $service
     */
    public function __construct(ActiveCampaignService $service)
    {
        $this->service = $service;
    }

    /**
     * Creates an ActiveCampaign list.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function createList()
    {
        try {
            return response()->api([
                'data' => $this->service->createList(),
            ], Status::CREATED);
        } catch (Throwable $t) {
            $this->logError($t);
        }
    }

    /**
     * Sync all leads to a new ActiveCampaign list.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncAll()
    {
        try {
            $list = $this->service->createList();

            Lead::chunk(self::SIZE, function ($leads) use ($list) {
                foreach ($leads as $lead) {
                    $this->service->syncContact($lead, $list->id);
                }
            });

            return response()->api([
                'data' => $list,
            ], Status::CREATED);
        } catch (Throwable $t) {
            $this->logError($t);
        }
    }
}
