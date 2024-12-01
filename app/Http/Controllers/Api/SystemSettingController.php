<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\SystemSetting\SystemSettingInterface;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
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
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
