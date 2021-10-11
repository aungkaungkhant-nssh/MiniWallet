<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TranscationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $title="";
        if($this->type===1){
            $title="From ".$this->source->name;
        }
        if($this->type===2){
            $title="To ".$this->source->name;
        }
        return [
            "trx_id"=>$this->trx_id,
            "amount"=>number_format($this->amount),
            "type"=>$this->type,
            "title"=>$title
        ];
    }
}
