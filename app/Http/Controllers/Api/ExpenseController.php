<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;
use App\Http\Resources\ExpenseResource;
use App\Repositories\Expense\ExpenseInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    use ApiResponse;

    private $expenseRepository;

    public function __construct(ExpenseInterface $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allExpenses()
    {
        $data = $this->expenseRepository->all();
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(ExpenseResource::collection($data), $metaData);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('perpage');
        $data = $this->expenseRepository->allPaginate($perPage);
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metaData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseStoreRequest $request)
    {
        try {
            $data = $this->expenseRepository->store($request);
            return $this->ResponseSuccess(new ExpenseResource($data), null, 'Data Stored Successfully!', 201);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->expenseRepository->show($id);
        // $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(new ExpenseResource($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseUpdateRequest $request, string $id)
    {
        try {
            $data = $this->expenseRepository->update($request, $id);
            return $this->ResponseSuccess(new ExpenseResource($data), null, 'Data Updated Successfully!', 200);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = $this->expenseRepository->delete($id);
            return $this->ResponseSuccess(new ExpenseResource($data), null, 'Data Deleted Successfully!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Change status of specified resource from storage.
     */
    public function status(string $id)
    {
        //
    }
}
