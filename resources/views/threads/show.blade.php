@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#">{{$thread->creator->name}}</a> posted:
                    <b>{{$thread->title}}</b>
                </div>
                <div class="card-body">
                    <p>{{$thread->body}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach($thread->replies as $reply)
                @include('threads.reply')
            @endforeach
        </div>
    </div>
    @if(auth()->check())
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New Reply</div>
                    <div class="card-body">
                        <form action="/threads/{{ $thread->channel->slug}}/{{$thread->id}}/replies" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control" name="body" id="body" rows="5" placeholder="Type this if you have that say..."></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @else
        <p class="text-center">Please <a href="{{route('login')}}">sign in</a> if you want participate to forum</p>
    @endif

</div>
@endsection
