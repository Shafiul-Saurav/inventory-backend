<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'supplier_id' => $this->id,
            'supplier_role_id' => $this->role_id,
            'supplier_name' => $this->name,
            'supplier_phone' => $this->phone,
            'supplier_email' => $this->email,
            'supplier_nid' => $this->nid,
            'supplier_address' => $this->address,
            'supplier_company_name' => $this->company_name,
            'supplier_file' => $this->file,
            'created_at' => $this->created_at->format('d/M/Y H:i A'),
            'is_active' => $this->is_active? 'active' : 'inactive'
        ];
    }
}
