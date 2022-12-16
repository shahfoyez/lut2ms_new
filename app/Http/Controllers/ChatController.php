<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatReply;
use App\Mail\ChatResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;

class ChatController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        // $chats = Chat::latest()->with('chatReply.admin')->get();
        $chats = Chat::latest()->with('chatReply.admin')->get();

        // dd(json_encode($chats));
        return view('chats', [
            'chats' => $chats
        ]);
    }

    public function store(StoreChatRequest $request)
    {
        // return response($request)->setStatusCode(200);
        // dd($request);
        $data = request()->all();
        $token = Str::upper(Str::random(10));
        $receiver = $request['email'];

        $request['token'] = $token;
        try {
            $chat= Chat::create([
                'name'=> $data['name'],
                'email'=> $data['email'],
                'student_id'=> $data['student_id'],
                'message'=> $data['user_message'],
                'token' => $token,
                'status' => 0
            ]);
            $content = array(
                'success' => true,
                'data' => $chat,
                'message' => trans('Message send successfully')
            );
            Mail::to($receiver)->send(new ChatResponse($request));
            return response($content)->setStatusCode(200);
        } catch (\Exception $e) {
            $content = array(
                'success' => false,
                'data' => 'something went wrong.',
                'message' => 'There was an error while processing your request: ' .
                    $e->getMessage()
            );
            return response($content)->setStatusCode(500);
        }
    }
    public function reply(Request $request)
    {
        // dd(request()->all());
        $attributes= $request->validate([
            'message'=> 'required',
            'chat_id' => 'required',
            'name' => 'required|string',
            'email'=>  'required|email',
            'token' => 'required|string',
            'user_message' => 'required|string'
        ]);

        $reply = ChatReply::create([
            'chat_id' => $attributes['chat_id'],
            'message'=> $attributes['message'],
            'admin_id'=>  auth()->user()->id,
        ]);
        if($reply){
            $receiver = $attributes['email'];
            Mail::to($receiver)->send(new ChatResponse($attributes));

            $statusUpdate = Chat::where('id', $request['chat_id'])
                ->Where('status', 0)
                ->update([
                    'status' => 1
                ]);
            return redirect('/chat/chats')->with('success', 'Mail send successfully');
        }else{
            return redirect('/chat/chats')->with('error', 'Something went wrong!');
        }
    }
    public function search(Request $request)
    {
        // dd(request()->all());
        if($request->input('search') == ''){
            return back();
        }
        $attributes= $request->validate([
            'search'=> 'required|string|min:1',
        ]);
        $search = $request['search'];
        // $chats = Chat::latest()->with('chatReply.admin')->get();
        $chats = Chat::latest()->with('chatReply.admin')
        ->where('email', 'like', '%' .$search. '%')
        ->orWhere('token', 'like', '%' .$search. '%')
        ->get();
        // dd($chats);

        // dd(json_encode($chats));
        return view('chats', [
            'chats' => $chats,
            'keyword' => $search
        ]);

    }

    public function destroy(Chat $chat)
    {
        //
    }
}
