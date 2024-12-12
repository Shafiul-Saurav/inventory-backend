<?php

namespace App\Repositories\Supplier;

interface SupplierInterface
{
    public function all();
    public function allPaginate($perPage);
    public function show($id);
    public function store($requestData);
    public function update($requestData, $id);
    public function delete($id);
    public function status($id);
}
