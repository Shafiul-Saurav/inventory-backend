<?php

namespace App\Repositories\Staff;
use App\Models\User as Staff;
use App\Service\FileUploadService;
use Illuminate\Support\Facades\Hash;

class StaffRepository implements StaffInterface
{
    private $filePath = 'public/Staff';

    /*
    * @return mixed|void
    */
    public function all()
    {
        $data = Staff::staff()->latest('id')->get();

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function allPaginate($perPage)
    {
        $data = Staff::staff()->latest('id')
        ->when(request('search'), function ($query) {
            $query->where('name', 'like', '%'.request('search').'%')
            ->orWhere('phone', 'like', '%'.request('search').'%')
            ->orWhere('email', 'like', '%'.request('search').'%')
            ->orWhere('nid', 'like', '%'.request('search').'%')
            ->orWhere('address', 'like', '%'.request('search').'%');
        })
        ->paginate($perPage);

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function show($id)
    {
        $data = Staff::findOrFail($id);
        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function store($requestData)
    {
        $data = Staff::create([
            'role_id' => Staff::STAFF,
            'name' => $requestData->name,
            'phone' => $requestData->phone,
            'email' => $requestData->email,
            'nid' => $requestData->nid,
            'address' => $requestData->address,
            'password' => Hash::make(1234),
        ]);

        /* Image Upload */
        $imagePath = (new FileUploadService())->imageUpload($requestData, $data, $this->filePath);
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
            'role_id' => Staff::STAFF,
            'name' => $requestData->name,
            'phone' => $requestData->phone,
            'email' => $requestData->email,
            'nid' => $requestData->nid,
            'address' => $requestData->address,
            'password' => Hash::make(1234),
        ]);

        /* Image Upload */
        $imagePath = (new FileUploadService())->imageUpload($requestData, $data, $this->filePath);
        /* Update File Stage */

        $data->update([
            'file' => 'http://localhost:8000'.$imagePath
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
