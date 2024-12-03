<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'category_id' => $this->id,
            'category_name' => $this->name,
            'category_slug' => $this->slug,
            'category_code' => $this->code,
            'category_file' => $this->file,
            'created_at' => $this->created_at->format('d/M/Y H:i A'),
            'is_active' => $this->is_active? 'active' : 'inactive'
        ];
    }
}
