<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'expense_id' => $this->id,
            'expense_category_id' => $this->expense_category_id,
            'expense_staff_id' => $this->staff_id,
            'expense_amount' => $this->amount,
            'expense_note' => $this->note,
            'expense_file' => $this->file,
            'created_at' => $this->created_at->format('d/M/Y H:i A'),
        ];
    }
}
