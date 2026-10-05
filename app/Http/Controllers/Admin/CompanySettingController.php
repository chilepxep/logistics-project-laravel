<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanySetting;

class CompanySettingController extends Controller
{
    public function edit()
    {
       
        $setting = CompanySetting::firstOrCreate(['id' => 1]);
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = CompanySetting::findOrFail(1);
        
        $setting->update([
            'hotline' => $request->hotline,
            'email' => $request->email,
            'zalo_link' => $request->zalo_link,
            'facebook_link' => $request->facebook_link,
            
            'addresses' => array_filter($request->addresses ?? []) 
        ]);

        return back()->with('success', 'Cập nhật thông tin công ty thành công!');
    }
}