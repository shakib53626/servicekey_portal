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
