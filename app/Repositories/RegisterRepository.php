<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterRepository {
    /**
     * @var user
     */
    protected $user;

    /**
     * RegisterRepository constructor.
     * 
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;  
    }

    public function login($data)
    {
        if (!Auth::attempt($data)) {
            $result = [
                'success' => false,
                'message' => 'abc'
            ];
        }
        
        Auth::login(Auth::user());
        $accessToken = Auth::user()->createToken('auth-token')->accessToken;
  
        $result = [
            'success' => true,
            'token' => $accessToken,
            'user_info' => [
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                '_id' => Auth::user()->id,
            ],
        ];

        return $result;
    }

    public function register($data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return $result = [
            'success' => true,
        ];
    }
}
