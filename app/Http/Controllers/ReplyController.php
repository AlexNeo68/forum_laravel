<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\RedirectResponse;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Thread $thread
     * @return RedirectResponse
     */
    public function store($channelId, Thread $thread)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);

        return back();
    }

}
