@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Thread</div>

                <div class="card-body">
                    <form action="{{route('threads.store')}}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Channel ID</label>
                            </div>
                            <select name="channel_id" class="custom-select" id="inputGroupSelect01">
                                <option>Choose...</option>
                                @foreach($channels as $channel)
                                    <option value="{{$channel->id}}">{{$channel->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" value="{{old('title')}}" class="form-control" id="title" name="title" placeholder="Type title...">
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea class="form-control" id="body" name="body" placeholder="Type body...">{{old('body')}}</textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                        @if($errors->count())
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
