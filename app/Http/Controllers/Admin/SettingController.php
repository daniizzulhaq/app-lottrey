<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::all()
            ->keyBy('key');

        return view(
            'admin.settings.index',
            compact('settings')
        );
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => [
                'nullable',
                'string',
                'max:255'
            ],

            'customer_service' => [
                'nullable',
                'string',
                'max:255'
            ],

            'minimum_topup' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'maximum_topup' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'minimum_redeem' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'maximum_redeem' => [
                'nullable',
                'numeric',
                'min:0'
            ],
        ]);

        foreach ($validated as $key => $value) {

            WebsiteSetting::updateOrCreate(
                [
                    'key' => $key
                ],
                [
                    'value' => $value,
                    'type' => is_numeric($value)
                        ? 'number'
                        : 'text'
                ]
            );
        }

        return back()->with(
            'success',
            'Pengaturan website berhasil diperbarui.'
        );
    }
}
