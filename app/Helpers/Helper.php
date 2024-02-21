<?php


function send_ms($msg, $status, $code)
{
    $res = [
        'success' => $status,
        'message' => $msg,
    ];

    return response()->json($res, $code);
}
