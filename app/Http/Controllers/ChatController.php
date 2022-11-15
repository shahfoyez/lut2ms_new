<?php

namespace App\Http\Controllers;

use App\Models\Chat;
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
        $chats = Chat::latest()->get();
        // dd($chats);
        return view('chats', [
            'chats' => $chats
        ]);
    }

    public function store(StoreChatRequest $request)
    {
        $data = request()->all();
        try {
            $chat= Chat::create([
                'name'=> $data['name'],
                'email'=> $data['email'],
                'student_id'=> $data['student_id'],
                'message'=> $data['message'],
                'status' => 0
            ]);
            $content = array(
                'success' => true,
                'data' => $chat,
                'message' => trans('Message send successfully')
            );
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChatRequest  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
