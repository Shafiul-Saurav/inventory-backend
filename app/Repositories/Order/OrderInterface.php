<?php

namespace App\Repositories\Order;

interface OrderInterface
{
    public function all();
    public function allPaginate($perPage);
    public function show($id);
    public function store($requestData);
}
