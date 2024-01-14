<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "message"=> $this->message,
            "user_id"=> $this->user_id,
            "time"=> $this->created_at->diffForHumans(),
            "name"=> $this->name
        ];
    }
}
