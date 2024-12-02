<?php

namespace App\Repositories\SystemSetting;

use App\Models\SystemSetting;

class SystemSettingRepository implements SystemSettingInterface
{
    /*
    * @return mixed|void
    */
    public function all()
    {
        $data = SystemSetting::firstOrFail();
        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function store($request_data)
    {
        $data = SystemSetting::create([
            'site_name' => 'Inventory Shop 1',
            'site_logo' => null,
            'site_favicon' => null,
            'site_phone' => 123456789,
            'site_email' => 'admin@inventory.com',
            'site_facebook_link' => 'inventory@facebook.com',
            'meta_keywords' => 'POS, Inventory, Shopping',
            'meta_description' => 'Its a multi-product inventory shop'
        ]);

        return $this->show($data->id);
    }

    /*
    * @return mixed|void
    */
    public function show($id)
    {
        $data = SystemSetting::findOrFail($id);
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
            'site_name' => $request_data->site_name,
            'site_logo' => $request_data->site_logo,
            'site_favicon' => $request_data->site_favicon,
            'site_phone' => $request_data->site_phone,
            'site_email' => $request_data->site_email,
            'site_facebook_link' => $request_data->site_facebook_link,
            'meta_keywords' => $request_data->meta_keywords,
            'meta_description' => $request_data->meta_description
        ]);

        return $data;
    }

    public function delete($id)
    {
        $data = $this->show($id);
        $data->delete();

        return true;
    }
}
