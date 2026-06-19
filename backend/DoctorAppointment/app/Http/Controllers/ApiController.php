<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
     public function successResponse($data, $code = 200, $message = null){
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ],$code);
    }
    public function errorResponse( $message = null, $code ){
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ],$code);
    }
}
