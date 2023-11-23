<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddLevelRequest;
use App\Http\Requests\AddPostRequest;
use App\Http\Requests\UpdateLevelRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Level;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\Tag;
use App\Services\Dashboard\PostService;
use App\Traits\General;
use App\Traits\Photoable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use Photoable;
    private $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('admin.Posts.index');
    }

    public function dataTable()
    {
        return datatables(Post::query()
            ->with('tag','category')
            ->orderBy('id', 'DESC'))
            ->editColumn('action', function($row) {
                $button  = '<div class="row">';
                $button .= '<div class="col-md-12 col-sm-6">';
                $button .= '<a class="btn btn-sm btn-info" style="margin-right: 5px;margin-bottom: 5px !important;" href="' . url('manager/posts/' .$row->id . '/edit') . '"><i class="fa fa-edit"></i></a>';
                $button .= '<button class="btn btn-sm btn-danger" style="margin-right: 5px;margin-bottom: 5px !important;" value="' . $row->id . '" id="delete-model" ><i class="fa fa-trash"></i></button>';
                $button .= '</div></div>';
                return $button;
            })
            ->editColumn('image', function($row) {
                if($row->image != null)
                {
                    $url = Storage::url("files/posts/images/" . $row->id . "/thumb-" . $row->image);
                    return '<img src="'.$url.'" style="width: 50px; height: 50px; padding: 2px;">';
                }
            })

            ->editColumn('tag', function($row) {
                if($row->tag_id != null)
                {
                    return $row->tag->title;
                }
            })
            ->editColumn('category', function($row) {
                if($row->category_id != null)
                {
                    return $row->category->title;
                }
            })
            ->editColumn('featured', function($row) {
                if($row->featured == 1)
                {
                    return '<span class="badge badge-pill bg-success">Yes</span>';
                }else{
                    return '<span class="badge badge-pill bg-warning">No</span>';
                }
            })
            ->editColumn('status', function($row) {
                if($row->featured == 1)
                {
                    return '<span class="badge badge-pill bg-success">Publish</span>';
                }else{
                    return '<span class="badge badge-pill bg-warning">Draft</span>';
                }
            })
            ->editColumn('date', function($row) {
               return Carbon::parse($row->created_at)->diffForHumans();
            })
            ->rawColumns(['image','tag','category','featured','status','date' ,'action'])
            ->toJson();
    }

    public function create()
    {
        $tags = Tag::get();
        $categories = Category::get();
        $categoryTypes = CategoryType::get();
        return view('admin.Posts.add',compact('tags','categories','categoryTypes'));
    }

    public function getCategories(Request $request)
    {
        $categories = Category::where('category_type_id',$request->id)->get();
        return response()->json($categories);
    }

    public function store(AddPostRequest $request)
    {
        $this->service->store($request);
        $notification = array('message' => "Post Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/posts')->with($notification);
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $tags = Tag::get();
        $categories = Category::get();
        $categoryTypes = CategoryType::get();
        $postEn = PostTranslation::where('post_id',$id)->where('locale','=','en')->select('title as title_en','description as description_en')->first();
        $postAr = PostTranslation::where('post_id',$id)->where('locale','=','ar')->select('title as title_ar','description as description_ar')->first();
        return view('admin.Posts.edit',compact('post','tags','categories','categoryTypes','postEn','postAr'));
    }
    public function update(AddPostRequest $request, Post $post)
    {
        $this->service->update($request, $post);
        $notification = array('message' => "Post Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/posts/')->with($notification);
    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->image != null)
            $this->deleteFile($post->image,$post->id, 'posts/images/');
        $post->delete();
        return response()->json(['message' => "Post Has been Deleted Successfully!"],200);
    }
}
