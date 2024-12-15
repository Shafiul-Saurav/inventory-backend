<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'staff_id' => $this->id,
            'staff_role_id' => $this->role_id,
            'staff_name' => $this->name,
            'staff_phone' => $this->phone,
            'staff_email' => $this->email,
            'staff_nid' => $this->nid,
            'staff_address' => $this->address,
            'staff_file' => $this->file,
            'created_at' => $this->created_at->format('d/M/Y H:i A'),
            'is_active' => $this->is_active? 'active' : 'inactive'
        ];
    }
}
