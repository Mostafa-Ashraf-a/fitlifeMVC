<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SMSController extends Controller
{
    protected $url = "";
    protected $userName = '';
    protected $userPassword = '';
    protected $numbers = '966597555447, 966597000855';
    protected $userSender = ''; #Indvidual Fitlife #Collection Fitlife_AD
    protected $msg = 'اختبار نظام الرسائل الفورية';
    protected $by = '';
    protected $infos = 'YES';
    protected $YesRepeat = 1;
    protected $dateTimeSendLater = '2014-12-30--23:59:00';
    protected $xml = '';

    public function __construct()
    {
        $this->url = env('SMS_URL');
        $this->userName = env('SMS_USERNAME');
        $this->userPassword = env('SMS_PASSWORD');
        $this->userSender = env('SMS_USER_SENDER');
        $this->by = env('SMS_BY');
    }

    public function send(Request $request)
    {
        $phone = "0" . $request->phone;
        $search = ['0'];
        $replace = ['966'];
        $this->numbers = str_replace($search, $replace, $phone);

        $data =  array(
            'userName' => $this->userName,
            'userPassword' => $this->userPassword,
            'userSender' => "",
            'numbers' => $this->numbers,
            'msg' => "كود التحقق: 11111",
            'By' => $this->by
        );

        $response = Http::get($this->url, $data)->json();
        $feedback = $this->errors($response);

        return response()->json([
            "Response" => $feedback,
            "Code" => $response
        ]);
    }

    public function errors($SendingResult)
    {
        if ($SendingResult == "1") {
            return "تم إرسال الرسالة بنجاح";
        } elseif ($SendingResult == "1010") {
            return "معلومات ناقصة.. اسم المستخدم أو كلمة المرور أو في محتوى الرسالة أو الرقم";
        } elseif ($SendingResult == "1020") {
            return "بيانات الدخول خاطئة";
        } elseif ($SendingResult == "1030") {
            return "نفس الرسالة مع نفس الاتجاه توجد في الملحق، انتظر عشر ثواني قبل إعادة إرسالها";
        } elseif ($SendingResult == "1040") {
            return "حروف غير معترف بها ";
        } elseif ($SendingResult == "1050") {
            return "الرسالة فارغة، السبب:الانتقاء قد سبب حذف محتوى الرسالة";
        } elseif ($SendingResult == "1060") {
            return "اعتماد غير كافي لعميلة الإرسال";
        } elseif ($SendingResult == "1070") {
            return "رصيدك 0 ، غير كافي لعملية الإرسال";
        } elseif ($SendingResult == "1080") {
            return "رسالة غير مرسلة ، خطأ في عملية إرسال رسالة";
        } elseif ($SendingResult == "1090") {
            return "تكرير عملية الانتقاء أنتج الرسالة";
        } elseif ($SendingResult == "1100") {
            return "عذرا ، لم يتم إرسال الرسالة. حاول في وقت لاحق";
        } elseif ($SendingResult == "1110") {
            return "عذرا، هناك اسم مرسل خاطئ ثم استعماله، حاول من جديد تصحيح الاسم";
        } elseif ($SendingResult == "1120") {
            return "عذرا ، هذا البلد الذي تحاول الإرسال له لا تشمله شبكتنا";
        } elseif ($SendingResult == "1130") {
            return "عذرا، راجع المشرف على شبكاتنا باعتبار الشبكة المحددة في حسابكم";
        } elseif ($SendingResult == "1140") {
            return "عذرا ، تجاوزت الحد الأقصى لأجزاء الرسائل. حاول إرسال عدد أقل من الأجزاء";
        } elseif ($SendingResult == "1150") {
            return "هذه الرسالة مكررة بنفس رقم الجوال واسم المرسل ونص الرسالة";
        } elseif ($SendingResult == "1160") {
            return "هناك مشكلة في مدخلات تاريخ وتوقيت الإرسال اللاحق";
        } else {
            return $SendingResult;
        }
    }
}
