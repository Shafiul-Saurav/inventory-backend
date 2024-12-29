<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Repositories\Order\OrderInterface;

class OrderController extends Controller
{
    use ApiResponse;

    private $orderRepository;

    public function __construct(OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allOrders()
    {
        $data = $this->orderRepository->all();
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data, Found!', 200, 'error');
        }
        return $this->ResponseSuccess(OrderResource::collection($data), $metaData);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('perpage');
        $data = $this->orderRepository->allPaginate($perPage);
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data, Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metaData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $this->orderRepository->store($request);
            return $this->ResponseSuccess(new OrderResource($data), null, 'Data Stored Successfully!', 201);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->orderRepository->show($id);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(new OrderResource($data));
    }

}
