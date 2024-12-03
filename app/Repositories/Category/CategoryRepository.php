<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryInterface
{
    /*
    * @return mixed|void
    */
    public function all()
    {
        $datas = Category::latest('id')->get();
        return $datas;
    }

    /*
    * @return mixed|void
    */
    public function allPaginate($perPage)
    {
        $datas = Category::latest('id')->paginate($perPage);
        return $datas;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function store($request_data)
    {
        $data = Category::create([
            'name' => $request_data->name,
            'slug' => Str::slug($request_data->name),
            'code' => $request_data->code,
        ]);

        return $this->show($data->id);
    }

    /*
    * @return mixed|void
    */
    public function show($id)
    {
        $data = Category::findOrFail($id);
        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function update($request_data, $id)
    {
        $data = $this->show($id);
        $data->update([
            'name' => $request_data->name,
            'slug' => Str::slug($request_data->name),
            'code' => $request_data->code,
        ]);

        return $data;
    }

    public function delete($id)
    {
        $data = $this->show($id);
        $data->delete();

        return true;
    }

    public function status($id)
    {
        $data = $this->show($id);
        if ($data->is_active == 1) {
            $data->is_active = 0;
        } elseif($data->is_active == 0) {
            $data->is_active = 1;
        }
        $data->save();
        return $data;
    }
}
