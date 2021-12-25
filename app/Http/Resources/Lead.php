<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Lead extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email_address' => $this->email_address,
            'industry' => $this->industry,
            'consent' => $this->consent,
            'created_at' => Carbon::createFromDate($this->created_at)->format('d-m-Y H:i:s'),
            'updated_at' => Carbon::createFromDate($this->updated_at)->format('d-m-Y H:i:s'),
        ];
    }
}
