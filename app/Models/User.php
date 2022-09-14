<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_users', 'user_id', 'chat_id')->withPivot('message', 'unread_count', 'last_message');
    }

    public static function getChat($user_id)
    {
        return Chat::whereHas('users', function ($subquery) use ($user_id) {
            $subquery->where('user_id', $user_id)->where('status', 1);
        })->get(); 
    }

    public static function checkJoinConversation($conversationId, $userId)
    {
        $chatUser = ChatUser::where('user_id', $userId)
                ->where('chat_id', $conversationId)->where('status', 1)->orderByDesc('id')->first();
        if (is_null($chatUser)) {
            return false;
        }
        return true;
    }
}
