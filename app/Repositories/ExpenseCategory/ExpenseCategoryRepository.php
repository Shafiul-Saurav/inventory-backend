<?php

namespace App\Repositories\ExpenseCategory;

use Illuminate\Support\Str;
use App\Models\ExpenseCategory;
use App\Service\FileUploadService;

class ExpenseCategoryRepository implements ExpenseCategoryInterface
{
    private $filePath = 'public/expensecategory';

    /*
    * @return mixed|void
    */
    public function all()
    {
        $data = ExpenseCategory::latest('id')->get();

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function allPaginate($perPage)
    {
        $data = ExpenseCategory::latest('id')
        ->when(request('search'), function($query){
            $query->where('name', 'like', '%'.request('search').'%');
        })
        ->paginate($perPage);

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function show($id)
    {
        $data = ExpenseCategory::findOrFail($id);

        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function store($requestData)
    {
        $data = ExpenseCategory::create([
            'name' => $requestData->name,
            'slug' => Str::slug($requestData->name),
        ]);

        /* Image Upload */
        $imagePath = (new FileUploadService())->fileUpload($requestData, $data, $this->filePath);

        /* Update File Stage */
        $data->update([
            'file' => 'http://localhost:8000'.$imagePath
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
        ]);


        if ($requestData->hasFile('file')) {
            /* Image Upload */
            $imagePath = (new FileUploadService())->fileUpload($requestData, $data, $this->filePath);

            /* Update File Stage */
            $data->update([
                'file' => 'http://localhost:8000'.$imagePath
            ]);
        }
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
        } elseif ($data->is_active == 0) {
            $data->is_active = 1;
        }

        $data->save();

        return $data;
    }
}
