<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarCodeService
{
    public function generateBarCode($model, $path='public/uploads') :string
    {
        $generatorPNG = new BarcodeGeneratorPNG();
        $image = $generatorPNG->getBarcode($model->code, $generatorPNG::TYPE_CODE_128);

        $barcodePath = Storage::put($path.'/'.$model->id.'.png', $image, 'public');

        return Storage::url($path.'/'.$model->id.'.png');
    }
}
