<?php

namespace App\Repositories\Supplier;

use App\Models\User as Supplier;
use App\Service\FileUploadService;
use Illuminate\Support\Facades\Hash;

class SupplierRepository implements SupplierInterface
{
    private $filePath = 'public/supplier';
    /*
    * @return mixed|void
    */
    public function all()
    {
        $data = Supplier::supplier()->latest('id')->get();

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function allPaginate($perPage)
    {
        $data = Supplier::supplier()
        ->latest('id')
        ->when(request('search'), function($query) {
            $query->where('name', 'like', '%'.request('search').'%')
            ->orWhere('phone', 'like', '%'.request('search').'%')
            ->orWhere('email', 'like', '%'.request('search').'%')
            ->orWhere('nid', 'like', '%'.request('search').'%')
            ->orWhere('address', 'like', '%'.request('search').'%')
            ->orWhere('company_name', 'like', '%'.request('search').'%');
        })
        ->paginate($perPage);

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function show($id)
    {
        $data = Supplier::findOrFail($id);
        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function store($requestData)
    {
        $data = Supplier::create([
            'role_id' => Supplier::SUPPLIER,
            'name' => $requestData->name,
            'phone' => $requestData->phone,
            'email' => $requestData->email,
            'nid' => $requestData->nid,
            'address' => $requestData->address,
            'company_name' => $requestData->company_name,
            'password' => Hash::make(1234),

        ]);

        /* Image Upload */
        $imagePath = (new FileUploadService())->fileUpload($requestData, $data, $this->filePath);

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
            'role_id' => Supplier::SUPPLIER,
            'name' => $requestData->name,
            'phone' => $requestData->phone,
            'email' => $requestData->email,
            'nid' => $requestData->nid,
            'address' => $requestData->address,
            'company_name' => $requestData->company_name,
        ]);

        /* Image Upload */
        $imagePath = (new FileUploadService())->fileUpload($requestData, $data, $this->filePath);

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
