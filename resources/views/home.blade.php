@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                                        <img class="img-fluid col-2" src="uploads/pokeball.png" alt="">
                                    @else
                                        <img class="img-fluid col-1" src="{{ 'uploads/' . $tweet->user_id->avatar }}" alt="">
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
    </div>
</div>
@endsection