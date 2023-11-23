<?php


namespace App\Services\API\User\Profile;


use App\Traits\Photoable;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    use Photoable;

    public function updateProfileImage($request, $user)
    {
        $this->userHasImage($request, $user);
        $this->userDoesntHasImage($request, $user);
    }

    private function userHasImage($request, $user): void
    {
        if ($request->hasFile('image') &&
            ($user->image != null && Storage::disk('public')->exists('files/users/images/' . $user->id))) {
            $this->deleteFile($user->image, $user->id, 'users/images/');
            $file = $request->file('image');
            $fileName = $this->uploadImage($file, $user->id, 'users/images/');
            $user->update([
                'image' => $fileName
            ]);
        }
    }

    private function userDoesntHasImage($request, $user): void
    {
        if ($request->hasFile('image') &&
            ($user->image == null)) {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file, $user->id, 'users/images/');
            $user->update([
                'image' => $fileName
            ]);
        }
    }
}
