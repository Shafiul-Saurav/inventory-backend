<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseCategoryResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'expense_category_id' => $this->id,
            'expense_category_name' => $this->name,
            'expense_category_slug' => $this->slug,
            'expense_category_file' => $this->file,
            'created_at' => $this->created_at->format('d/M/Y H:i A'),
            'is_active' => $this->is_active? 'active' : 'inactive'
        ];
    }
}
