<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function imageUpload($request, $model, $path = 'public/uploads')
    {
        if ($request->hasFile('file')) {
            $uploaded_file = $request->file('file');
            // If Old File Exists, delete it
            if ($model->file) {
                Storage::delete($model->file);
            }

            $file_extension = $uploaded_file->getClientOriginalExtension();
            // Dynamically name the file with the model ID and extension
            $file_name = $model->id . '.jpg';
            $file_upload_url = Storage::putFileAs($path, $uploaded_file, $file_name, 'public');

            return Storage::url($file_upload_url);
        }
        return null;
    }
    public function fileUpload($request, $model, $path = 'public/uploads')
    {
        if ($request->hasFile('file')) {
            $uploaded_file = $request->file('file');
            // If Old File Exists, delete it
            if ($model->file) {
                Storage::delete($model->file);
            }

            $file_extension = $uploaded_file->getClientOriginalExtension();
            // Dynamically name the file with the model ID and extension
            $file_name = $model->id . '.' . $file_extension;
            $file_upload_url = Storage::putFileAs($path, $uploaded_file, $file_name, 'public');

            return Storage::url($file_upload_url);
        }
        return null;
    }
}
