<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('pages.setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // 1. Get all data except token
        $data = $request->except('_token');

        // 2. Handle Site Logo independently
        if ($request->hasFile('site_logo')) {
            $data['site_logo'] = $request->file('site_logo')->store('settings', 'public');
        }

        // 3. Handle Bank Logo independently
        if ($request->hasFile('bank_logo')) {
            $data['bank_logo'] = $request->file('bank_logo')->store('settings', 'public');
        }

        // 4. Save settings
        foreach ($data as $key => $value) {
            // Ensure we don't try to save null if the file wasn't updated
            if ($value !== null) {
                Setting::set($key, $value);
            }
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
