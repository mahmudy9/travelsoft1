<?php


function apiRes($msg , $status , $data=null)
{
    return response()->json([
            'msg' => $msg,
            'status' => $status , 
            'data' => $data,
    ]);
}
