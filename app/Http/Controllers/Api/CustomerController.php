<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Resources\CustomerResource;
use App\Repositories\Customer\CustomerInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use ApiResponse;

    private $customerRepository;

    public function __construct(CustomerInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allCustomers()
    {
        $data = $this->customerRepository->all();
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }

        return $this->ResponseSuccess(CustomerResource::collection($data), $metaData);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('perpage');
        $data = $this->customerRepository->allPaginate($perPage);
        $metaData['count'] = count($data);

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metaData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request)
    {
        try {
            $data = $this->customerRepository->store($request);
            return $this->ResponseSuccess(new CustomerResource($data), null, 'Data Stored Successfully!', 201);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->customerRepository->show($id);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }

        return $this->ResponseSuccess(new CustomerResource($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerUpdateRequest $request, string $id)
    {
        try {
            $data = $this->customerRepository->update($request, $id);
            return $this->ResponseSuccess(new CustomerResource($data), null, 'Data Updated Successfully!', 200);
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
            $data = $this->customerRepository->delete($id);
            return $this->ResponseSuccess(new CustomerResource($data), null, 'Data Deleted Successfully!', 204);
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
            $data = $this->customerRepository->status($id);
            return $this->ResponseSuccess(new CustomerResource($data), null, 'Status Changed Successfully!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }
}
