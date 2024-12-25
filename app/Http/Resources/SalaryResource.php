<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'salary_id' => $this->id,
            'salary_staff_id' => $this->staff_id,
            'salary_amount' =>  $this->amount,
            'salary_date' => $this->date,
            'salary_month' => $this->month,
            'salary_year' => $this->year,
            'salary_type' => $this->type,
            'created_at' => $this->created_at->format('d/M/Y, H:i A')
        ];
    }
}
