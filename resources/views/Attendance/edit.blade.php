@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session()->has('success'))
        <div class="success">
            {{ session()->get('success') }}
        </div>
        @endif
        @if (session()->has('error'))
            <div class="danger">
                {{ session()->get('error') }}
            </div>
        @endif
        <form method="POST" action="{{ route('attend.update', $attend->id)}}">
            @method('PUT')
            @csrf
            <div class="card" style="padding: 10px;">
                <div class="card-header card-header" style="background-color: white">
                    <h4 style="color: black" class="card-title">{{ __('Edit Attendee') }}</h4>
                    <p class="card-category" style="color: black">{{ __('Update Attendee Information') }}</p>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="input-field col s6">
                            <input placeholder="Band" name="band" value="{{$attend->band}}" type="text" class="validate">
                            <label for="band">Band</label>
                        </div>
                        <div class="input-field col s6">
                            <input name="status" value="{{$attend->status}}" type="text" class="validate">
                            <label for="status">Status</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input placeholder="Name and Surname" name="name_surname" value="{{$attend->name_surname}}" type="text" class="validate">
                            <label for="name_surname">Name and Surname</label>
                        </div>
                        <div class="input-field col s6">
                            <input name="instrument" value="{{$attend->instrument}}" type="text" class="validate">
                            <label for="instrument">Instrument</label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card-footer ml-auto mr-auto">
                    <button id="submit-button" class="btn" style="background-color: rgb(31, 81, 255)">{{ __('Update') }}</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection
