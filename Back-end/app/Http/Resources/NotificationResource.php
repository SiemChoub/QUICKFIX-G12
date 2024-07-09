<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
     return [
        'id' => $this->id,
        // 'user_id' => $this->user_id,
        'text' => $this->text,
        // 'booking_id' => $this->booking_id,
        // 'booking'=>$this->booking,
        'booking' => $this->booking ? [
            // 'id' => $this->booking->id,
            // 'user_id' => $this->booking->user_id,
            'user' => $this->booking->user->name,
            'booking_type_id' => $this->booking->booking_type_id,
            'type' => $this->booking->type,
        ] : null,
        'role_id' => $this->role_id->name,
        // 'role' => $this->role,
        'role' => $this->role ? ['name' => $this->role->name] : null,
        'updated_at' => $this->updated_at,
        'deleted_at' => $this->deleted_at,
        'created_at' => $this->created_at,
    ];
    }
}
