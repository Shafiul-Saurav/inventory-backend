<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->id,
            'product_category_id' => $this->category_id,
            'product_brand_id' => $this->brand_id,
            'product_supplier_id' => $this->supplier_id,
            'product_name' => $this->name,
            'product_slug' => $this->slug,
            'product_original_price' => $this->original_price,
            'product_sell_price' => $this->sell_price,
            'product_stock' => $this->stock,
            'product_description' => $this->description,
            'product_code' => $this->code,
            'product_barcode' => $this->barcode,
            'product_qrcode' => $this->qrcode,
            'product_file' => $this->file,
            'created_at' => $this->created_at->format('d/M/Y H:i A'),
            'is_active' => $this->is_active? 'active' : 'inactive'
        ];
    }
}
