<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

class ThreadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index(Channel $channel)
    {
        $threads = $this->getThreads($channel);

        return view('threads.index', compact('threads'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(Request $request)
    {

        request()->validate([
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id',
        ]);

        $thread = Thread::create([
            'title' => request('title'),
            'body' => request('body'),
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
        ]);
        return redirect($thread->path());
    }

    public function show($channelId, Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    public function edit(Thread $thread)
    {
        //
    }

    public function update(Request $request, Thread $thread)
    {
        //
    }

    public function destroy(Thread $thread)
    {
        //
    }

    /**
     * @param Channel $channel
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getThreads(Channel $channel): \Illuminate\Database\Eloquent\Collection
    {
        if ($channel->exists) {
            $threads = $channel->threads()->latest();
        } else {
            $threads = Thread::latest();
        }

        if ($username = request('by')) {
            $user = User::where('name', $username)->first();
            $threads->where('user_id', $user->id);
        }

        $threads = $threads->get();
        return $threads;
    }
}
