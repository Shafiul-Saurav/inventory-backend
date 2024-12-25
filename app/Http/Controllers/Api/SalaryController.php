<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryStoreRequest;
use App\Http\Requests\SalaryUpdateRequest;
use App\Http\Resources\SalaryResource;
use App\Models\Salary;
use App\Repositories\Salary\SalaryInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    use ApiResponse;

    private $salaryRepository;

    public function __construct(SalaryInterface $salaryRepository)
    {
        $this->salaryRepository = $salaryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function allSalaries()
    {
        $data = $this->salaryRepository->all();
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(SalaryResource::collection($data), $metaData);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('perpage');
        $data = $this->salaryRepository->allPaginate($perPage);
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metaData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalaryStoreRequest $request)
    {
        try {
            /** Check Salary Already Paid or Not */
            $check = Salary::where(['staff_id' => $request->staff_id, 'month' => $request->month, 'year' => $request->year])->count();
            if ($check == 0) {
                $data = $this->salaryRepository->store($request);
                return $this->ResponseSuccess(new SalaryResource($data), null, 'Data Stored Successfully!', 201);
            }

            return $this->ResponseError($check, null, 'Already Paid!', 400);

        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->salaryRepository->show($id);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(new SalaryResource($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalaryUpdateRequest $request, string $id)
    {
        try {
            $data = $this->salaryRepository->update($request, $id);
            return $this->ResponseSuccess(new SalaryResource($data), null, 'Data Updated Successfully!', 200);
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
            $data = $this->salaryRepository->delete($id);
            return $this->ResponseSuccess(new SalaryResource($data), null, 'Data Deleted Successfully!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }
}
