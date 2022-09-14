<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepository;
use InvalidArgumentException;

class UserService {

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;  
    }

    public function get_conversations()
    {
        $result = $this->userRepository->get_conversations();
        return $result;
    }

    public function get_messages($data)
    {
        $validator = Validator::make($data, [
            'conversation_id' => 'required',
        ]);

        if ($validator->fails()) {
            $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
            // throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->userRepository->get_messages($data);
        
        return $result;
    }

    public function join_conversation($data)
    {
        $validator = Validator::make($data, [
            'conversation_id' => 'required',
        ]);

        if ($validator->fails()) {
            $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        DB::beginTransaction();

        try {
            $result = $this->userRepository->join_conversation($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            // throw new InvalidArgumentException('Unable to ...');
        }

        DB::commit();
        
        return $result;
    }

    public function add_to_conversation($data)
    {
        $validator = Validator::make($data, [
            'conversation_id' => 'required',
            // 'list_user' => 'required',
        ]);

        if ($validator->fails()) {
            $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        DB::beginTransaction();

        try {
            $result = $this->userRepository->add_to_conversation($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
        }

        DB::commit();
        
        return $result;
    }

    public function remove_from_conversation($data)
    {
        $validator = Validator::make($data, [
            'conversation_id' => 'required',
            // 'list_user' => 'required',
        ]);

        if ($validator->fails()) {
            $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        DB::beginTransaction();

        try {
            $result = $this->userRepository->remove_from_conversation($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
        }

        DB::commit();
        
        return $result;
    }

    public function get_conversation_data($data)
    {
        $validator = Validator::make($data, [
            'conversation_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        DB::beginTransaction();

        try {
            return $result = $this->userRepository->get_conversation_data($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
        }

        DB::commit();
    }

    public function leave_conversation($data)
    {
        $validator = Validator::make($data, [
            'conversation_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        DB::beginTransaction();

        try {
            return $result = $this->userRepository->leave_conversation($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
        }

        DB::commit();
    }

    public function search_user($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        return $result = $this->userRepository->search_user($data);
    }

    public function delete_conversation($data)
    {
        $validator = Validator::make($data, [
            'conversation_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        DB::beginTransaction();

        try {
            return $result = $this->userRepository->delete_conversation($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
        }

        DB::commit();
    }

    public function change_conversation_name($data)
    {
        $validator = Validator::make($data, [
            'conversation_id' => 'required',
            'conversation_name' => 'required|string', 
        ]);

        if ($validator->fails()) {
            return $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        DB::beginTransaction();

        try {
            return $result = $this->userRepository->change_conversation_name($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
        }

        DB::commit();
    }

    public function create_conversation($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'user_ids' => 'required'
        ]);

        if ($validator->fails()) {
            return $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        DB::beginTransaction();

        try {
            return $result = $this->userRepository->create_conversation($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
        }

        DB::commit();
    }

    public function upload_user_avatar($data)
    {
        $validator = Validator::make($data, [
            'avatar'=> 'required|image|mimes:jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        DB::beginTransaction();

        try {
            return $result = $this->userRepository->upload_user_avatar($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
        }

        DB::commit();
    }

    public function upload_conversation_avatar($data)
    {
        $validator = Validator::make($data, [
            'conversation_id' => 'required',
            'avatar' => 'required|image|mimes:jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        DB::beginTransaction();

        try {
            return $result = $this->userRepository->upload_conversation_avatar($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
        }

        DB::commit();
    }

    public function change_user_name($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        }

        return $result = $this->userRepository->upload_conversation_avatar($data);
    }
}
