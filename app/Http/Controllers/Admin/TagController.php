<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddNewGoalRequest;
use App\Http\Requests\TagRequest;
use App\Http\Requests\UpdateGoalRequest;
use App\Models\Goal;
use App\Models\Post;
use App\Models\Tag;
use App\Models\TagTranslation;
use App\Traits\General;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')->get();
        return view('admin.Tags.index',compact('tags'));
    }
    public function create()
    {
        return view('admin.Tags.add');
    }

    public function store(TagRequest $request)
    {
        $tagData = [
            'en' => ['title'  => $request->title_en],
            'ar' => ['title'  => $request->title_ar],
        ];
        Tag::create($tagData);
        $notification = array('message' => "Tag Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/tags')->with($notification);
    }

    public function edit($id)
    {
        $tagEn = TagTranslation::where('tag_id',$id)->where('locale','=','en')->select('title as title_en')->first();
        $tagAr = TagTranslation::where('tag_id',$id)->where('locale','=','ar')->select('title as title_ar')->first();
        return view('admin.Tags.edit',compact('tagEn','id','tagAr'));
    }
    public function update(TagRequest $request, Tag $tag)
    {
        $tagData = [
            'en' => ['title'  => $request->title_en],
            'ar' => ['title'  => $request->title_ar],
        ];
        $tag->update($tagData);
        $notification = array('message' => "Tag Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/tags')->with($notification);
    }
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $post = Post::where('tag_id', $id)->first();
        if($post)
        {
            return response()->json(['message' => "You can`t delete the Tag, it has a Post"],400);
        }
        $tag->delete();
        return response()->json(['message' => "Tag Has been Deleted Successfully!"],200);
    }
}
