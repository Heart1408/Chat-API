<?php

namespace App\Services;

use App\Repositories\RegisterRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class RegisterService {
    /**
     * @var registerRepository
     */
    protected $registerRepository;

    /**
     * RegisterRepository constructor.
     * 
     * @param RegisterRepository $registerRepository
     */
    public function __construct(RegisterRepository $registerRepository)
    {
        $this->registerRepository = $registerRepository;  
    }

    public function login($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
            // throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->registerRepository->login($data);
        
        return $result;
    }

    public function register($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email|unique:App\Models\User,email',
            'name' => 'required',
            'password' => 'required',  
            'confirm_password' => 'required|same:password',
        ]);
        
        if ($validator->fails()) {
            $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
            // throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $result = $this->registerRepository->register($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update skill data');
        }

        DB::commit();
        
        return $result;
    }
}
