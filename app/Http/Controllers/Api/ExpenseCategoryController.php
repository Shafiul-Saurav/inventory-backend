<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseCategoryStoreRequest;
use App\Http\Requests\ExpenseCategoryUpdateRequest;
use App\Http\Resources\ExpenseCategoryResourse;
use App\Repositories\ExpenseCategory\ExpenseCategoryRepository;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ExpenseCategoryController extends Controller
{
    use ApiResponse;

    private $expenseCategoryRepository;

    public function __construct(ExpenseCategoryRepository $expenseCategoryRepository)
    {
        $this->expenseCategoryRepository = $expenseCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allExpenseCategories()
    {
        $data = $this->expenseCategoryRepository->all();
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(ExpenseCategoryResourse::collection($data), $metaData);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('perpage');
        $data = $this->expenseCategoryRepository->allPaginate($perPage);
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metaData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseCategoryStoreRequest $request)
    {
        try {
            $data = $this->expenseCategoryRepository->store($request);
            return $this->ResponseSuccess(new ExpenseCategoryResourse($data), null, 'Data Stored Successfully!', 201);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->expenseCategoryRepository->show($id);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(new ExpenseCategoryResourse($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseCategoryUpdateRequest $request, string $id)
    {
        try {
            $data = $this->expenseCategoryRepository->update($request, $id);
            return $this->ResponseSuccess(new ExpenseCategoryResourse($data), null, 'Data Updated Successfully!', 200);
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
            $data = $this->expenseCategoryRepository->delete($id);
            return $this->ResponseSuccess(new ExpenseCategoryResourse($data), null, 'Data Deleted Successfully!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Change status of specified resource from storage.
     */
    public function status(string $id)
    {
        try {
            $data = $this->expenseCategoryRepository->status($id);
            return $this->ResponseSuccess(new ExpenseCategoryResourse($data), null, 'Status Changed Successfully!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }
}
