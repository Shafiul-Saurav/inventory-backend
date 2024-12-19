<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Service\BarCodeService;
use Illuminate\Support\Str;
use App\Service\FileUploadService;
use App\Service\QrCodeService;
use Illuminate\Support\Facades\Hash;

class ProductRepository implements ProductInterface
{
    private $filePath = 'public/product';
    /*
    * @return mixed|void
    */
    public function all()
    {
        $data = Product::with([
            'category:id,name,code',
        'brand:id,name,code',
        'supplier:id,name,phone,email,company_name'
        ])
        ->latest('id')->get();

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function allPaginate($perPage)
    {
        $data = Product::with([
            'category:id,name,code',
            'brand:id,name,code',
            'supplier:id,name,phone,email,company_name'
        ])
        ->latest('id')
        ->when(request('search'), function($query) {
            $query->where('name', 'like', '%'.request('search').'%')
            ->orWhere('code', 'like', '%'.request('search').'%');
        })
        ->paginate($perPage);

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function show($id)
    {
        $data = Product::findOrFail($id);

        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function store($requestData)
    {
        $data = Product::create([
            'category_id' => $requestData->category_id,
            'brand_id' => $requestData->brand_id,
            'supplier_id' => $requestData->supplier_id,
            'name' => $requestData->name,
            'slug' => Str::slug($requestData->name),
            'original_price' => $requestData->original_price,
            'sell_price' => $requestData->sell_price,
            'stock' => $requestData->stock,
            'description' => $requestData->description,
            'code' => $requestData->code,
        ]);

        /* Image Upload */
        $imagePath = (new FileUploadService())->imageUpload($requestData, $data, $this->filePath);

        /* BarCode Generate */
        $barCodePath = (new BarCodeService())->generateBarCode($data, $this->filePath);

        /* QrCode Generate */
        $qrCodePath = (new QrCodeService())->generateQrCode($data, $this->filePath);

        /* Update File Stage */
        $data->update([
            'file' => 'http://localhost:8000'.$imagePath,
            'barcode' => 'http://localhost:8000'.$barCodePath,
            'qrcode' => 'http://localhost:8000'.$qrCodePath,
        ]);

        return $this->show($data->id);
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function update($requestData, $id)
    {
        $data = $this->show($id);

        $data->update([
            'category_id' => $requestData->category_id,
            'brand_id' => $requestData->brand_id,
            'supplier_id' => $requestData->supplier_id,
            'name' => $requestData->name,
            'slug' => Str::slug($requestData->name),
            'original_price' => $requestData->original_price,
            'sell_price' => $requestData->sell_price,
            'description' => $requestData->description,
            'code' => $requestData->code,
        ]);

        /* Image Upload */
        $imagePath = (new FileUploadService())->imageUpload($requestData, $data, $this->filePath);

        /* BarCode Generate */
        $barCodePath = (new BarCodeService())->generateBarCode($data, $this->filePath);

        /* QrCode Generate */
        $qrCodePath = (new QrCodeService())->generateQrCode($data, $this->filePath);

        /* Update File Stage */
        $data->update([
            'file' => 'http://localhost:8000'.$imagePath,
            'barcode' => 'http://localhost:8000'.$barCodePath,
            'qrcode' => 'http://localhost:8000'.$qrCodePath,
        ]);

        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function delete($id)
    {
        $data = $this->show($id);

        $data->delete();

        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function status($id)
    {
        $data = $this->show($id);
        if ($data->is_active == 1) {
            $data->is_active = 0;
        } elseif($data->is_active == 0) {
            $data->is_active = 1;
        }

        $data->save();

        return $data;

    }
}
