<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPostRequest;
use App\Http\Requests\FAQRequest;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Faq;
use App\Models\FaqTranslation;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\Tag;
use App\Traits\General;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    use General;
    public function index()
    {
        $faqs = Faq::orderBy('id', 'DESC')->get();
        return view('admin.FAQs.index',compact('faqs'));
    }
    public function create()
    {
        return view('admin.FAQs.add');
    }
    public function store(FAQRequest $request)
    {
        $request->validate([$request->all()]);
        $this->insertNewFaq($request);
        $notification = array('message' => "FAQ Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/faqs/')->with($notification);
    }
    private function insertNewFaq($request) : void{
        $faqData = [
            'en' => [
                'question'  => $request->question_en,
                'answer'  => $request->answer_en
            ],
            'ar' => [
                'question'  => $request->question_ar,
                'answer'  => $request->answer_ar
            ],
        ];
        Faq::create($faqData);
    }
    public function edit($id)
    {
        $faqEn = FaqTranslation::where('faq_id',$id)->where('locale','=','en')->select('question as question_en','answer as answer_en')->first();
        $faqAr = FaqTranslation::where('faq_id',$id)->where('locale','=','ar')->select('question as question_ar','answer as answer_ar')->first();
        return view('admin.FAQs.edit',compact('id','faqAr','faqEn'));
    }
    public function update(FAQRequest $request, Faq $faq)
    {
        $faqData = [
            'en' => [
                'question'  => $request->question_en,
                'answer'  => $request->answer_en
            ],
            'ar' => [
                'question'  => $request->question_ar,
                'answer'  => $request->answer_ar
            ],
        ];
        $faq->update($faqData);
        $notification = array('message' => "Faq Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/faqs/')->with($notification);
    }
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        return response()->json(['message' => "FAQ Has been Deleted Successfully!"],200);
    }
}
