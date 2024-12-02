<?php

namespace App\Trait;

trait ApiResponse
{
    public function ResponseSuccess($data, $metaData = null, $message = 'Successfull!', $status_code = 200, $status = 'success')
    {
        return response()->json([
            'status' => $status,
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data,
            'metaData' => $metaData,
        ]);
    }
    public function ResponseError($errors, $metaData = null, $message = 'Data Process Error!', $status_code = 400, $status = 'error')
    {
        return response()->json([
            'status' => $status,
            'status_code' => $status_code,
            'message' => $message,
            'errors' => $errors,
            'metaData' => $metaData,
        ]);
    }
    public function ResponseInfo($info, $metaData = null, $message = 'Notification!', $status_code = 200, $status = 'info')
    {
        return response()->json([
            'status' => $status,
            'status_code' => $status_code,
            'message' => $message,
            'info' => $info,
            'metaData' => $metaData,
        ]);
    }
}
