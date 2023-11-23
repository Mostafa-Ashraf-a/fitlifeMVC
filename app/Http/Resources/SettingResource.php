<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'privacy_policy'        => $this->privacy_policy,
            'terms_of_service'      => $this->terms_of_service,
            'about_us'              => $this->about_us,
            'contact_us'            => [
              'mobile'       => $this->mobile,
              'email'        => $this->email,
              'site_url'     => $this->site_url,
            ],
            'introduction_video' => [
                'url'           => $this->intro_video ? secure_url(Storage::url('files/settings/videos/' . $this->id . '/' . $this->intro_video)) : null
            ],
            'created_at'            => $this->created_at
        ];
    }
}
