<?php

namespace App\Repositories\Expense;

interface ExpenseInterface
{
    public function all();
    public function allPaginate($perPage);
    public function show($id);
    public function store($requestData);
    public function update($requestData, $id);
    public function delete($id);
}
