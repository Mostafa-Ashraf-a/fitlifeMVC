<?php


namespace App\Traits\V2;


trait ApiResponseStructure
{

    public function sendResponse($result = [], $message = ' ', $is_success = true, $status_code = 200)
    {
        $result_key = $is_success ? 'payload' : 'errors';

        $response   = [
            'code'        => $status_code,
            'error'       => $is_success == true ? false : true,
            'message'     => $message,
            $result_key   => $result
        ];
        if (isset($result['data']) && isset($result['links']) && isset($result['meta'])) {
            $response['payload']  = $result['data'];
            $response['links'] = $result['links'];
            $response['meta']  = $result['meta'];
        }
        return response()->json($response, $status_code);
    }
}
