<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RegisterService;

class RegisterController extends Controller
{ 
    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function login(Request $request)
    {
        $data = $request->only([
            'email',
            'password',
        ]);

        try {
            $result =  $this->registerService->login($data);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    public function register(Request $request){
        $data = $request->only([
            'email',
            'name',
            'password',
            'confirm_password',
        ]);

        try {
            $result =  $this->registerService->register($data);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }
}
