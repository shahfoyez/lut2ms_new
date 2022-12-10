<?php

namespace App\Http\Controllers;

use App\Models\ChatReply;
use App\Http\Requests\StoreChatReplyRequest;
use App\Http\Requests\UpdateChatReplyRequest;

class ChatReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreChatReplyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChatReplyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChatReply  $chatReply
     * @return \Illuminate\Http\Response
     */
    public function show(ChatReply $chatReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChatReply  $chatReply
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatReply $chatReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChatReplyRequest  $request
     * @param  \App\Models\ChatReply  $chatReply
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChatReplyRequest $request, ChatReply $chatReply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChatReply  $chatReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatReply $chatReply)
    {
        //
    }
}
