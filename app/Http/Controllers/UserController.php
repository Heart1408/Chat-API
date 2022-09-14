<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function get_conversations(Request $request)
    {
        try {
            $result =  $this->userService->get_conversations();
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($result); 
    }

    public function get_messages(Request $request)
    {
        $data = $request->only([
            'conversation_id',
            'page',
            'limit',
        ]);

        try {
            $result =  $this->userService->get_messages($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($result); 
    }

    public function join_conversation(Request $request)
    {
        $data = $request->only([
            'token',
            'conversation_id',
        ]);

        try {
            $result =  $this->userService->join_conversation($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($result); 
    }

    public function add_to_conversation(Request $request)
    {
        $data = $request->only([
            'token',
            'conversation_id',
            // 'list_user',
        ]);

        try {
            $result =  $this->userService->add_to_conversation($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($result);
    }

    public function remove_from_conversation(Request $request)
    {
        $data = $request->only([
            'token',
            'conversation_id',
            // 'list_user',
        ]);

        try {
            $result =  $this->userService->remove_from_conversation($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($result);
    }

    public function get_conversation_data(Request $request)
    {
        $data = $request->only([
            'token',
            'conversation_id',
            'limit',
            'page',
        ]);

        try {
            $result =  $this->userService->get_conversation_data($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($result);
    }

    public function leave_conversation(Request $request)
    {
        $data = $request->only([
            'token',
            'conversation_id',
        ]);

        try {
            $result =  $this->userService->leave_conversation($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($result);
    }

    public function search_user(Request $request)
    {
        $data = $request->only([
            'token',
            'name',
        ]);

        try {
            $result =  $this->userService->search_user($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($result);
    }

    public function delete_conversation(Request $request)
    {
        $data = $request->only([
            'token',
            'conversation_id',
        ]);

        try {
            $result =  $this->userService->delete_conversation($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($result);
    }

    public function change_conversation_name(Request $request)
    {
        $data = $request->only([
            'token', 
            'conversation_id',
            'conversation_name', 
        ]);

        try {
            $result =  $this->userService->change_conversation_name($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    public function create_conversation(Request $request)
    {
        $data = $request->only([
            'token',
            'name',
            'is_read',
            'user_ids'
        ]);

        try {
            $result =  $this->userService->create_conversation($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    public function upload_user_avatar(Request $request)
    {
        $data = $request->only([
            'token',
            'avatar',
        ]);

        try {
            $result =  $this->userService->upload_user_avatar($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    public function upload_conversation_avatar(Request $request)
    {
        $data = $request->only([
            'token',
            'conversation_id',
            'avatar',
        ]);

        try {
            $result =  $this->userService->upload_conversation_avatar($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    public function change_user_name(Request $request)
    {
        $data = $request->only([
            'name',
        ]);

        try {
            $result =  $this->userService->change_user_name($data);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }
}
