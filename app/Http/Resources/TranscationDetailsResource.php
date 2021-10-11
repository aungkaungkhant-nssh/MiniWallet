<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TranscationDetailsResource extends JsonResource
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
            "trx_id"=>$this->trx_id,
            "ref_id"=>$this->ref_id,
            "type"=>$this->type,
            "amount"=>number_format($this->amount),
            "title"=>$this->source?$this->source->name:0,
            "date"=>Carbon::parse($this->created_at)->format("Y-m-d H:i:s")
        ];
    }
}
