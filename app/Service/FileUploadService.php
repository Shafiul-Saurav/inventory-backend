<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function imageUpload($request, $model, $path = 'public/uploads')
    {
        if ($request->file != null) {
            $uploaded_file = $request->file;

            /* If Old File Exist */
            if ($model->file != null) {
                Storage::delete($model->file);
            }

            $file_extension = $uploaded_file->getClientOriginalExtension();
            $file_upload_url = Storage::putFileAs($path, $uploaded_file, $model->id.'.'.$file_extension, 'public');

            return Storage::url($file_upload_url);
        }

        return;
    }
}
