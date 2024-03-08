<?php


function send_ms($msg, $status, $code)
{
    $res = [
        'success' => $status,
        'status'  => $code,
        'message' => $msg,
    ];

    return response()->json($res, $code);
}

function sendError($message, $code = 400)
{
    $response = [
        "success" => false,
        "message" => $message,
    ];

    return response()->json($response, $code);
}

function sendResponse($data, $status, $msg, $code){
    $res = [
        'success' => $status,
        'status'  => $code,
        'message' => $msg,
        'result'  => $data,
    ];

    return response()->json($res, $code);
}
