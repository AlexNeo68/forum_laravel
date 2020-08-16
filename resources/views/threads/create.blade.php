@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Thread</div>

                <div class="card-body">
                    <form action="{{url('threads')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" value="{{old('title')}}" id="title" name="title" placeholder="Type title...">
                            @error('title')
                                <div class="alert mt-2 alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea class="form-control" id="body" name="body" placeholder="Type body...">{{old('body')}}</textarea>
                            @error('body')
                                <div class="alert mt-2 alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="channel_id">Channel</label>
                            <select class="form-control" id="channel_id" name="channel_id">
                                <option value="">- Choose one channel -</option>
                                @foreach($channels as $channel)
                                    <option
                                        {{old('channel_id') == $channel->id ? 'selected' : ''}}
                                        value="{{$channel->id}}">{{$channel->name}}</option>
                                @endforeach
                            </select>
                            @error('channel_id')
                                <div class="alert mt-2 alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
