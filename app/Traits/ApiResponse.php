<?php


namespace App\Traits;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

trait ApiResponse
{
    /*
    * core of response
    *
    * @param int                 $statusCode
    * @param boolean             $isSuccess
    * @param string              $message
    * @param array|object        $data
    */
    public function coreResponse($message, $statusCode, $data = null, $isSuccess = true)
    {
        // Check the params
        if(!$message)
        {
            return response()->json(['message' => 'Message is required'],500);
        }
        // Send the response
        if($isSuccess)
        {
            return response()->json([
                'code'      => $statusCode,
                'error'     => false,
                'message'   => $message,
                'payload'   => $data
            ], $statusCode);
        }else{
            return response()->json([
                'code'      => $statusCode,
                'error'     => true,
                'message'   => $message,
                'payload'   => $data
            ], $statusCode);
        }
    }

    /*
    * Send any success response
    *
    * @param int                 $statusCode
    * @param boolean             $isSuccess
    * @param string              $message
    * @param array|object        $data
    */
    public function success($message,$data)
    {
        return $this->coreResponse($message,200,$data,true);
    }

    /*
   * Send any error response
   *
   * @param int                 $statusCode
   * @param boolean             $isSuccess
   * @param string              $message
   * @param array|object        $data
   */
    public function error($message, $statusCode = 422)
    {
        return $this->coreResponse($message,$statusCode,null,false);
    }
    /*
       * Send any response has pagination
       *
       * @param array | object        $paginator
       * @param int                   $page
       * @param array|object          $item
       */
    public function responseWithPagination($paginator, $items,$page)
    {
        if($paginator->url($page))
        {
            $data = [
                'code'             => 200,
                'error'            => false,
                'message'          => " ",
                'payload'          => $items
            ];
            return response()->json($data,200);
        }
    }
    public function paginate($items, $perPage = 10, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $pa = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page);
        return $pa;
    }

    public function noContentResponse()
    {
        return response()->json('',204);
    }

}
