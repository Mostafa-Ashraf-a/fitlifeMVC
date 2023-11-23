<?php


namespace App\Services\Dashboard;


use App\Models\Post;
use App\Traits\Photoable;
use Illuminate\Support\Facades\Storage;

class PostService
{
    use Photoable;

    /**
     * @param $request
     */
    public function store($request) : void
    {
        $post = $this->storePost($request);
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$post->id, 'posts/images/');
            $post->update([
                'image' => $fileName
            ]);
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    private function storePost($request) : mixed
    {
        return Post::create([
            'en' => [
                'title'        => $request->title_en,
                'description'  => $request->description_en
            ],
            'ar' => [
                'title'        => $request->title_ar,
                'description'  => $request->description_ar
            ],
            'tag_id'               => $request->tag_id,
            'category_id'          => $request->category_id,
            'category_type_id'     => $request->category_type_id,
            'featured'             => $request->featured,
            'status'               => $request->status,
        ]);
    }

    /**
     * @param $request
     * @param $post
     */
    public function update($request, $post) : void
    {
        $this->updatePost($post, $request);

        if($request->hasFile('image') &&
            ($post->image != null && Storage::disk('public')->exists('files/posts/images/'.$post->id)))
        {
            $this->deleteFile($post->image,$post->id, 'posts/images/');
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$post->id, 'posts/images/');
            $post->update([
                'image' => $fileName
            ]);
        }
        if($request->hasFile('image') &&
            ($post->image == null))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$post->id, 'posts/images/');
            $post->update([
                'image' => $fileName
            ]);
        }
    }
    /**
     * @param $post
     * @param $request
     */
    public function updatePost($post, $request): void
    {
        $post->update([
            'en' => [
                'title'            => $request->title_en,
                'description'      => $request->description_en
            ],
            'ar' => [
                'title'            => $request->title_ar,
                'description'      => $request->description_ar
            ],
            'tag_id'               => $request->tag_id,
            'category_id'          => $request->category_id,
            'category_type_id'     => $request->category_type_id,
            'featured'             => $request->featured,
            'status'               => $request->status,
        ]);
    }
}
