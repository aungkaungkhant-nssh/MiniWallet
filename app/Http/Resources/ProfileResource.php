<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $unread_notification=$this->unreadNotifications->count();
        return [
            "name"=>$this->name,
            "email"=>$this->email,
            "phone"=>$this->phone,
            "account_number"=>$this->wallets->account_number,
            "amount"=>$this->wallets?number_format($this->wallets->amount):0,
            "notification"=>$unread_notification
        ];
    }
}
