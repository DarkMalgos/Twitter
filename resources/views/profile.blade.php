@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="row align-items-center justify-content-around">
            <div class="col-6">
                <div class="card flex-row bg-white p-3 mb-2 align-items-center">
                    <div class="col-6">
                        @if($users->avatar == null)
                            <img class="img-fluid col-12" src="/uploads/pokeball.png" alt="">
                        @else
                            <img class="img-fluid col-12" src="{{ '/uploads/' . $users->avatar }}" alt="">
                        @endif
                    </div>
                    <div class="col-6">
                        <a href="{{ '/users/' . $users->id }}" class="mb-0">{{ '@'.$users->username }}</a>
                        @if($users->id !== Auth::user()->id)
                            <form action="/follow">
                                <input type="hidden" name="current" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="profile" value="{{ $users->id }}">
                                <button type="submit" class="btn btn-outline-info">follow</button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="card flex-row align-items-center justify-content-between bg-white p-3">
                    <div class="col-3 d-flex flex-column align-items-center justify-content-center">
                        <p class="mb-0">Tweets</p>
                        <p>{{ sizeof($tweets) }}</p>
                    </div>
                    <div class="col-3 d-flex flex-column align-items-center justify-content-center">
                        <p class="mb-0">Abonnements</p>
                        <p>0</p>
                    </div>
                    <div class="col-3 d-flex flex-column align-items-center justify-content-center">
                        <p class="mb-0">Abonnés</p>
                        <p>0</p>
                    </div>
                </div>
            </div>
            @if($users->id === Auth::user()->id)
                <div class="col-6">
                <form class="card align-items-end p-3 bg-white" method="POST" action="/">
                    <div class="form-group col-12">
                        <textarea class="form-control" id="tweetMessage" name="message" rows="3" placeholder="quoi de neuf teutteur ?!"></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-info text-white">
                                twitter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>
        @if(sizeof($tweets) > 0)
            <div class="col-md-8 m-5">
                <p class="text-white">Tweets</p>
                <div class="d-flex flex-column-reverse">
                @foreach($tweets as $tweet)
                    <div class="card bg-white m-4 p-2">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-10">
                                <div class="row align-items-center justify-content-start">
                                    <div class="col-12">
                                        @if($tweet->user_id->avatar == null)
                                            <img class="img-fluid col-2" src="/uploads/pokeball.png" alt="">
                                        @else
                                            <img class="img-fluid col-1" src="{{ '/uploads/' . $tweet->user_id->avatar }}" alt="">
                                        @endif
                                        <a href="{{ '/users/' . $tweet->user_id->id }}" class="mb-0">{{ '@'.$tweet->user_id->username }}</a>
                                    </div>
                                </div>
                            </div>
                            @if($tweet->user_id->id === Auth::user()->id)
                                <div class="col-1">
                                    <form method="POST" action="{{ route('removeTweet', [$tweet->id]) }}" class="row align-items-center justify-content-center">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-link"><i class="far fa-trash-alt text-danger fa-2x"></i></button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <p class="mb-3 mt-3">{{ $tweet->message }}</p>
                    </div>
                @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection