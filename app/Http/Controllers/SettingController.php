<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $keys = ['company_name', 'company_email', 'company_phone', 'company_address', 'default_language', 'default_currency'];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
            }
        }

        return back()->with('success', __('messages.settings_saved'));
    }

    public function updateLanguage(Request $request)
    {
        $request->validate(['language' => 'required|string|max:5']);
        $supported = array_keys(config('languages.supported', []));

        if (in_array($request->language, $supported)) {
            session(['locale' => $request->language]);
            Auth::user()->update(['language_preference' => $request->language]);
        }

        return back()->with('success', __('messages.language_updated'));
    }
}
