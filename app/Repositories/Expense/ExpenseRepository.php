<?php

namespace App\Repositories\Expense;

use Illuminate\Support\Str;
use App\Models\Expense;
use App\Service\FileUploadService;

class ExpenseRepository implements ExpenseInterface
{
    private $filePath = 'public/expense';

    /*
    * @return mixed|void
    */
    public function all()
    {
        $data = Expense::with([
            'expenseCategory:id,name',
            'staff:id,name,phone,email'
        ])
        ->latest('id')->get();

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function allPaginate($perPage)
    {
        $data = Expense::with([
            'expenseCategory:id,name',
            'staff:id,name,phone,email'
        ])
        ->latest('id')
        ->when(request('search'), function($query){
            $query->where('amount', 'like', '%'.request('search').'%')
            ->orWhere('created_at', 'like', '%'.request('search').'%');
        })
        ->paginate($perPage);

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function show($id)
    {
        $data = Expense::findOrFail($id);

        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function store($requestData)
    {
        $data = Expense::create([
            'expense_category_id' => $requestData->expense_category_id,
            'staff_id' => $requestData->staff_id,
            'amount' => $requestData->amount,
            'note' => $requestData->note,

        ]);

        /* Image Upload */
        $imagePath = (new FileUploadService())->fileUpload($requestData, $data, $this->filePath);

        /* Update File Stage */
        $data->update([
            'file' => 'http://localhost:8000'.$imagePath
        ]);

        return $this->show($data->id);
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function update($requestData, $id)
    {
        $data = $this->show($id);
        $data->update([
            'expense_category_id' => $requestData->expense_category_id,
            'staff_id' => $requestData->staff_id,
            'amount' => $requestData->amount,
            'note' => $requestData->note,
        ]);

        if ($requestData->hasFile('file')) {
            /* Image Upload */
            $imagePath = (new FileUploadService())->fileUpload($requestData, $data, $this->filePath);

            /* Update File Stage */
            $data->update([
                'file' => 'http://localhost:8000'.$imagePath
            ]);
        }
        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function delete($id)
    {
        $data = $this->show($id);

        $data->delete();

        return $data;
    }

}
