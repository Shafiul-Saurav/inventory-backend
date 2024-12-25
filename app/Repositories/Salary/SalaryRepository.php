<?php

namespace App\Repositories\Salary;

use App\Models\User;
use App\Models\Salary;
use App\Notifications\SalaryDisburseNotification;
use Illuminate\Support\Facades\Notification;

class SalaryRepository implements SalaryInterface
{
    private $filePath = 'public/salary';
    /*
    * @return mixed|void
    */
    public function all()
    {
        $data = Salary::with(['staff:id,name,email,phone,nid'])
        ->latest('id')->get();

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function allPaginate($perPage)
    {
        $data = Salary::with(['staff:id,name,email,phone,nid'])
        ->when(request('search'), function($query) {
            $query->where('staff_id', 'like', '%'.request('search').'%')
            ->orWhere('amount', 'like', '%'.request('search').'%')
            ->orWhere('date', 'like', '%'.request('search').'%')
            ->orWhere('type', 'like', '%'.request('search').'%');
        })
        ->latest('id')->paginate($perPage);

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function show($id)
    {
        $data = Salary::findOrFail($id);

        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function store($requestData)
    {
        $data = Salary::create([
            'staff_id' => $requestData->staff_id,
            'amount' =>  $requestData->amount,
            'date' => $requestData->date,
            'month' => $requestData->month,
            'year' => $requestData->year,
            'type' => $requestData->type,
        ]);

        /** Send Notifications to Admin and Staff */

        $staff = User::find($requestData->staff_id);
        $admins = User::admin()->get();

        $details = [
            'subject' => "Salary Disbursed for the $data->month / $data->year",
            'message' => "Dear $staff->name your salary for the month: $data->month / $data->year has been disburse.
            Please collect the cheque from the account department"
        ];

        Notification::send($staff, new SalaryDisburseNotification($details));
        Notification::send($admins, new SalaryDisburseNotification($details));

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
            'staff_id' => $requestData->staff_id,
            'amount' =>  $requestData->amount,
            'date' => $requestData->date,
            'month' => $requestData->month,
            'year' => $requestData->year,
            'type' => $requestData->type,
        ]);

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
