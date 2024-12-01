<?php

 namespace App\Repositories\SystemSetting;

 interface SystemSettingInterface
 {
    public function all();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function delete($id);
 }
