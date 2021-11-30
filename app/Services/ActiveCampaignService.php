<?php

namespace App\Services;

use App\Exceptions\ActiveCampaignService as Exception;
use App\Models\Lead;
use Gentor\ActiveCampaign\ActiveCampaignService as BaseService;

class ActiveCampaignService extends BaseService
{
    /**
     * Create a new service instance.
     */
    public function __construct()
    {
        parent::__construct([
            'api_url' => config('activecampaign.api_url'),
            'api_key' => config('activecampaign.api_key'),
        ]);
    }
     
    /**
     * Create an ActiveCampaign list.
     * 
     * @return object JSON
     *
     * @throws \App\Exceptions\ActiveCampaignService
     */
    public function createList(): object
    {
        $list = [
            'name'           => 'My List',
            'sender_name'    => 'My Company',
            'sender_addr1'   => '123 S. Street',
            'sender_city'    => 'Athens',
            'sender_zip'     => '11752',
            'sender_country' => 'GR',
        ];

        $result = $this->ac->api('list/add', $list);

        if (!$result->success) {
            throw new Exception('An error occured: ' . $result->error);
        }

        return $result;
    }

    /**
     * Add or edit a contact.
     * 
     * @param  \App\Models\Lead  $lead
     * @param  int  $listId
     * @return object JSON
     *
     * @throws \App\Exceptions\ActiveCampaignService
     */
    public function syncContact(Lead $lead, ?int $listId): object
    {
        $contact = [
            'email'                 => $lead->email_address,
            'first_name'            => $lead->first_name,
            'last_name'             => $lead->last_name,
            'p[' . $listId . ']'    => $listId,
            'status['. $listId .']' => 1,
        ];

        $result = $this->ac->api('contact/sync', $contact);

        if (!$result->success) {
            throw new Exception('An error occured: ' . $result->error);
        }

        return $result;
    }

    /**
     * Delete a contact.
     * 
     * @return string
     */
    public function deleteContact(): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => config('activecampaign.api_url') . '/api/3/contacts/5',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => [
                'Accept: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            return $response;
        }
    }
}
