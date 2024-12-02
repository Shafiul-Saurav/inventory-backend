<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSystemSettingRequest;
use App\Repositories\SystemSetting\SystemSettingInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    use ApiResponse;

    private $systemSettingInterface;

    public function __construct(SystemSettingInterface $systemSettingInterface)
    {
        $this->systemSettingInterface = $systemSettingInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->systemSettingInterface->all();
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSystemSettingRequest $request, string $id)
    {
        try {
            $data = $this->systemSettingInterface->update($request, $id);
            return $this->ResponseSuccess($data, null, 'Update Successfully!');
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

}
