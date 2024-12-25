<?php

namespace App\Repositories\Salary;

interface SalaryInterface
{
    public function all();
    public function allPaginate($perPage);
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function delete($id);
}
