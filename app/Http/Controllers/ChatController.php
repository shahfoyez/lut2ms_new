<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Mail\ChatResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $chats = Chat::latest()->get();
        // dd($chats);
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
        // return response($request)->setStatusCode(200);

        // $foo = (array)$request;
        // $request['token'] = $token;
        // $attributes = (object)$foo;
        // return response($request['email'])->setStatusCode(200);

        // $token = md5(microtime());
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
            'name' => 'required|string',
            'message'=> 'required',
            'email'=>  'required|email',
            'token' => 'required|string',
            'user_message' => 'required|string'

        ]);
        $receiver = $attributes['email'];
        Mail::to($receiver)->send(new ChatResponse($attributes));
        // dd($attributes['email']);

        return redirect('/chat/chats')->with('success', 'Mail send successfully');


    }

    public function show(Chat $chat)
    {
        //
    }

    public function edit(Chat $chat)
    {
        //
    }


    public function update(UpdateChatRequest $request, Chat $chat)
    {
        //
    }


    public function destroy(Chat $chat)
    {
        //
    }
}
