<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SettingTranslation;
use App\Traits\Photoable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use Photoable;
    public function index()
    {
        $settingEn = SettingTranslation::where('locale', 'en')->first();
        $settingAr = SettingTranslation::where('locale', 'ar')->first();
        $setting = Setting::first();
        return view('admin.settings.edit', compact('settingEn', 'settingAr', 'setting'));
    }
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'email'          => 'sometimes|nullable|email',
            'mobile'         => 'sometimes|nullable|integer',
            'site_url'       => 'sometimes|nullable|url',
            'intro_video'    => 'sometimes|nullable|mimes:mp4|max:20000',
        ]);

        if (
            $request->hasFile('intro_video') &&
            ($setting->intro_video != null && Storage::disk('public')->exists('files/settings/videos/' . $setting->id))
        ) {
            $this->deleteFile($setting->intro_video, $setting->id, 'settings/videos/');
            $file = $request->file('intro_video');
            $fileName = $this->uploadFile($file, $setting->id, 'settings/videos/');
            $setting->update([
                'intro_video' => $fileName
            ]);
        }

        if ($request->hasFile('intro_video') && ($setting->intro_video == null)) {
            $file = $request->file('intro_video');
            $fileName = $this->uploadFile($file, $setting->id, 'settings/videos/');

            $setting->update([
                'intro_video' => $fileName
            ]);
        }



        $setting->update([
            'en' => [
                'privacy_policy'   => $request->privacy_policy_en,
                'terms_of_service' => $request->terms_of_service_en,
                'about_us'         => $request->about_us_en,
            ],
            'ar' => [
                'privacy_policy'   => $request->privacy_policy_ar,
                'terms_of_service' => $request->terms_of_service_ar,
                'about_us'         => $request->about_us_ar,
            ],
            'email'     => $request->email,
            'mobile'     => $request->mobile,
            'site_url'     => $request->site_url,
        ]);
        $notification = array('message' => "Setting Updated Successfully!", 'alert-type' => 'info');
        return redirect()->back()->with($notification);
    }
}
