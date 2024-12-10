<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use App\Service\FileUploadService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandRepository implements BrandInterface
{
    private $filePath = 'public/brand';

    /*
    * @return mixed|void
    */
    public function all()
    {
        $data = Brand::latest('id')
        ->when(request('name'), function($query) {
            $query->where(['name' => request('name')]);
        })
        ->when(request('code'), function($query) {
            $query->where(['code' => request('code')]);
        })
        ->get();

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function allPaginate($perPage)
    {
        $data = Brand::latest('id')
        ->when(request('search'), function($query) {
            $query->where('name', 'like', '%'.request('search').'%')
                  ->orWhere('code', 'like', '%'.request('search').'%');
        })
        ->when(request('name'), function($query) {
            $query->where('name', request('name'));
        })
        ->when(request('code'), function($query) {
            $query->where('code', request('code'));
        })
        ->paginate($perPage);

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function show($id)
    {
        $data = Brand::findOrFail($id);
        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function store($requestData)
    {
        $data = Brand::create([
            'name' => $requestData->name,
            'slug' => Str::slug($requestData->name),
            'code' => $requestData->code,
        ]);

        /* Image Upload */
        $imagePath = (new FileUploadService())->imageUpload($requestData, $data, $this->filePath);

        /* Update File Stage */
        $data->update([
            'file' => 'http://localhost:8000'.$imagePath,
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
            'name' => $requestData->name,
            'slug' => Str::slug($requestData->name),
            'code' => $requestData->code,
        ]);

        /* Image Upload */
        $imagePath = (new FileUploadService())->imageUpload($requestData, $data, $this->filePath);

        /* Update File Stage */
        $data->update([
            'file' => 'http://localhost:8000'.$imagePath,
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

        // Delete the associated file if it exists
        // if ($data->file) {
        //     $filePath = str_replace(config('app.url') . '/', '', $data->file); // Remove base URL to get the relative path
        //     Storage::delete($filePath);
        // }
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
        } elseif ($data->is_active == 0) {
            $data->is_active = 1;
        }

        $data->save();

        return $data;
    }
}
