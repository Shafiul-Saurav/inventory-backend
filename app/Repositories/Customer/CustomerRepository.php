<?php

namespace App\Repositories\Customer;

use App\Models\User as Customer;
use App\Service\FileUploadService;
use Illuminate\Support\Facades\Hash;

class CustomerRepository implements CustomerInterface
{
    private $filePath = 'public/customer';
    /*
    * @return mixed|void
    */
    public function all()
    {
        $data = Customer::customer()->latest('id')->get();

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function allPaginate($perPage)
    {
        $data = Customer::customer()->latest('id')
        ->when(request('search'), function($query) {
            $query->where('name', 'like', '%'.request('search').'%')
            ->orWhere('phone', 'like', '%'.request('search').'%')
            ->orWhere('email', 'like', '%'.request('search').'%');
        })
        ->paginate($perPage);

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function show($id)
    {
        $data = Customer::findOrfail($id);

        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function store($requestData)
    {
        $data = Customer::create([
            'role_id' => Customer::CUSTOMER,
            'name' => $requestData->name,
            'phone' => $requestData->phone,
            'email' => $requestData->email,
            'password' => Hash::make(1234),
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
            'role_id' => Customer::CUSTOMER,
            'name' => $requestData->name,
            'phone' => $requestData->phone,
            'email' => $requestData->email,
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
