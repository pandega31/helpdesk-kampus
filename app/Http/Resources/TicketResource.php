<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'judul'     => $this->judul,
            'kategori'  => new CategoryResource($this->whenLoaded('category')),
            'prioritas' => $this->prioritas,
            'status'    => $this->status,
            'dibuat'    => $this->created_at->toDateTimeString(),
        ];
    }
}
