<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Chat;
use App\Models\ChatUser;

class UserRepository {

    public function __construct(User $user)
    {
        $this->user = $user;  
    }

    public function get_conversations()
    {
        $conversations = User::getChat(Auth::id());
        $data = [];
            
        foreach ($conversations as $con) {
            $members = [];
            $chat = ChatUser::where('chat_id', $con->id)->where('status', 1)->get();
            $unread_count = ChatUser::where('chat_id', $con->id)->where('user_id', Auth::id())->orderByDesc('id')->first();

            foreach ($chat as $c)
            {
                $user = User::where('id', $c->user_id)->first();
                $member = array(
                    "avatar" => $user->avatar,
                    "_id" => $user->id,
                    "email" => $user->email,
                    "name" => $user->name,
                );
                $members[] = $member;
            }

            $data[] = [
                "members" => $members,
                "avatar" => $con->avatar,
                "unread_count" => $unread_count->unread_count,
                "last_message" => $unread_count->last_message,
                "chat_id" => $con->id,
            ];
        }
        return $data;
    }

    public function get_messages($data) {
        $conversation_id = 2;

        $chat = ChatUser::where('chat_id', $conversation_id)->orderByDesc('id')->paginate(10);
        $data = [];
        foreach($chat as $c) {
            $user = User::where('id', $c->user_id)->first();
            
            $sender = [
                "id" => $user->id,
                "name" => $user->name,
            ];

            $data[] = [
                "content" => $c->message,
                "sender" => $sender,
                "createdAt" => $c->created_at,
            ];
        }

        $result = [
            'success' => true,
            'conversation_id' => $conversation_id,
            'data' => $data,
        ];

        return $result;
    }

    public function join_conversation($data)
    {
        if(!Auth::user()->checkJoinConversation($data['conversation_id'], Auth::id()))
        {
            $chat = Chat::find($data['conversation_id']);
            $chat->users()->attach(Auth::id(), ['message' => '']);

            return $result = [
                'success' => true,
                'message' => 'join conversation success!',
                'conversation_id' => $data['conversation_id'],
                'conversation_name' => $chat->name,
            ];
        }
    }

    public function add_to_conversation($data)
    {
        // $data['list_user'] = ['1', '2', '3', '4', '5'];
        $list_user = $data['list_user'];
        $list_user_success = [];
        $chat = Chat::find($data['conversation_id']);
        foreach ($list_user as $user) {
            if (!Auth::user()->checkJoinConversation($data['conversation_id'], $user))
            {
                $chat->users()->attach($user, ['message' => '']);
                $list_user_success[] = $user;
            }
        }

        if (count($list_user_success) == 0) {
            return $result = [
                'success' => "false",
            ];
        } 

        return $result = [
            'success' => 'true',
            'message' => 'add user success!',
            'conversation_id' => $data['conversation_id'],
            'conversation_name' => $chat->name,
            'list_user_success' => $list_user_success,
        ];
    }

    public function remove_from_conversation($data)
    {
        // $data['list_user'] = ['1', '5', '11'];
        $list_user = $data['list_user'];
        $list_user_success = [];
        $chat = Chat::find($data['conversation_id']);
        foreach ($list_user as $user) {
            if ($user == Auth::id())
            {
                continue;
            }
            if (Auth::user()->checkJoinConversation($data['conversation_id'], $user))
            {
                $remove_user = ChatUser::where('chat_id', $data['conversation_id'])
                    ->where('user_id', $user)->update(['status' => 0]);
                $list_user_success[] = $user;
            }
        }

        if (count($list_user_success) == 0) {
            return $result = [
                'success' => "false",
            ];
        } 

        return $result = [
            'success' => 'true',
            'message' => 'remove user success!',
            'conversation_id' => $data['conversation_id'],
            'conversation_name' => $chat->name,
            'list_user_success' => $list_user_success,
        ];
    }

    public function get_conversation_data($data)
    {
        {
            if (!Auth::user()->checkJoinConversation($data['conversation_id'], Auth::id())) {
                return $result = [
                    'success' => false,
                    'message' => '...',
                ];
            }

            $conversation = ChatUser::where('chat_id', $data['conversation_id'])->where('status', 1)->get();
            $messages = [];
            $members = [];
                
            foreach ($conversation as $con) {
                $user = User::find($con->user_id);
                $message = array(
                    "messageContent" => $con->message,
                    "ins_time" => "",
                    "sender_ID" => $con->user_id,
                );
                $messages[] = $message;

                $member = array(
                    "member_id" => $con->user_id,
                    "member_name" => $user->name,
                    "member_email" => $user->email,
                );
                $members[] = $member;
            }

            return $result = [
                'success' => true,
                'messageContent' => $messages,
                'conversation_id' => $data['conversation_id'],
                'conversation_name' => Chat::find( $data['conversation_id'])->name,
            ];
        }
    }

    public function leave_conversation($data)
    {
        if(Auth::user()->checkJoinConversation($data['conversation_id'], Auth::id()))
        {
            ChatUser::where('chat_id', $data['conversation_id'])
                ->where('user_id', Auth::id())->update(['status' => 0]);
            
            return $result = [
                'success' => 'true',
                'message' => 'leave success!',
                'conversation_id' => $data['conversation_id'],
                'conversation_name' => Chat::find($data['conversation_id'])->name,
            ];
        }
    }

    public function search_user($data)
    {
        $list_user = [];
        $users = User::where('name', 'like', '%'. $data['name'] .'%')->get();
        foreach ($users as $user)
        {
            $arr = [
                'name' => $user->name,
                '_id' => $user->id,
                'avatar' => $user->avatar,
            ];

            $list_user[] = $arr;
        }

        if (count($list_user) > 0) {
            return $result = [
                'success' => true,
                'list_user' => $list_user,
            ];
        } 

        return $result = [
            'success' => false,
        ];
    }

    public function delete_conversation($data)
    {
        $conversation = ChatUser::where('chat_id', $data['conversation_id']);
        $chat = Chat::find($data['conversation_id']);
        $conversation->delete();
        $chat->delete();

        return $result = [
            'success' => true,
            '_id' => $data['conversation_id'],
        ];
    }

    public function change_conversation_name($data)
    {
        $chat = Chat::find($data['conversation_id']);
        if ($data['conversation_name'] == $chat->name)
        {
            return $result = [
                'message' => 'name ....',
            ];
        } else {
            $chat->name = $data['conversation_name'];
            $chat->update();

            return $result = [
                'success' => true,
                'message' => "abc",
                'conversation_id' => $data['conversation_id'],
                'conversation_name' => $data['conversation_name'],
            ];
        }
    }

    public function create_conversation($data)
    {
        $conversation['name'] = $data['name'];
        $chat = Chat::create($conversation);

        $user_ids = $data['user_ids'];
        foreach ($user_ids as $id) {
            $chat->users()->attach($id, ['message' => '']);
        }

        return $result = [
            'success' => true,
            'message' => 'abc',
            'conversation_id' => $chat->id,
            'list_user_successfull' => $data['user_ids'],
        ];
    }

    public function upload_user_avatar($data)
    {
        $avatar = $data['avatar'];
        $storePath = $avatar->move('user_avatar', $avatar->getClientOriginalName());
        $user = Auth::user();
        $user->avatar = $storePath;
        $user->save();

        $user_info = [
            'name' => $user->name,
            'email' => $user->email,
            '_id' => $user->id,
        ];

        return $result = [
            'success' => true,
            'user_info' => $user_info,
        ]; 
    }

    public function upload_conversation_avatar($data)
    {
        // $avatar = $request->file('avatar');
        $avatar = $data['avatar'];
        $storePath = $avatar->move('conversation_avatar', $avatar->getClientOriginalName());
        $chat = Chat::find($data['conversation_id']);
        $chat->avatar = $storePath;
        $chat->save();

        return $result = [
            'success' => true,
        ]; 
    }

    public function change_user_name($data)
    {
        $user = Auth::user();
        if ($user->name == $data['name']) {
            return $result = [
                'success' => false,
                'message' => 'name ...',
            ];
        }

        $user->name = $data['name'];
        $user->update();

        return $result = [
            'success' => true,
            'user_info' => [
                'name' => $user->name,
                'email' => $user->email,
                'id' => $user->id,
            ],
        ];
    }
}
