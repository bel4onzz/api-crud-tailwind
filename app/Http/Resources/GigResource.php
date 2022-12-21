<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GigResource extends JsonResource
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
            'id' => $this->id,
            'company_id' => $this->company_id,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'name' => $this->name,
            'description' => $this->description,
            'start' => $this->start,
            'end' => $this->end,
            'number_of_position' => $this->number_of_position,
            'pay_per_hour' => $this->pay_per_hour,
            'status' => $this->status,
            'progress' => (isset($this->start) && !empty($this->start) && !(Carbon::parse($this->start)->year < 1)) ? $this->getProgress($this->start, $this->end) : 'Not started'
        ];
    }

    public function getProgress($start_date, $end_date)
    {
        if (isset($start_date) && !empty($start_date)) {
            if (isset($end_date) && !empty($end_date)) {
                if(Carbon::parse($end_date)->gte(Carbon::parse($start_date))){
                    return "Finished";
                }
                return "ERRORDATES";
            }
            return "Started";
        }
        return "Not started";
    }
}
