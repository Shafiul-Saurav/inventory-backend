<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    public function generateQrCode($model, $path='public/uploads') :string
    {
        $image = QrCode::format('svg')
                ->size(600)
                ->errorCorrection('H')
                ->generate($model->code);

        $qrcodePath = Storage::put($path.'/'.$model->id.'.svg', $image, 'public');

        return Storage::url($path.'/'.$model->id.'.svg');
    }
}
