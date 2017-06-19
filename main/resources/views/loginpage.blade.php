@extends('templates.template')
@section('css')
    container-body {
    background: url('https://www.planwallpaper.com/static/images/i-should-buy-a-boat.jpg') fixed;
    background-size: cover;
    padding: 0;
    margin: 0;
    }

    .form-holder {
    background: rgba(255,255,255,0.2);
    margin-top: 10%;
    border-radius: 3px;
    }



    .remember-me {
    text-align: left;
    }
    .ui.checkbox label {
    color: #ddd;
    }

@endsection
@section('body')



    <div class="ui container" style="width: 100% ;height: 100%; background-color: #9fa474">
        <div class="ui one column center aligned grid" >
            <div class="ui one column center aligned grid" id="loginform">
                <div class="column six wide form-holder">
                    <h2 class="center aligned header form-head">Sign in</h2>
                    <form class="ui form" method="post" action="{{url('user/signin')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <div class="ui form">
                            @if (count($errors) > 0)
                                <div class="ui ignored negative message">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if ( Session::has('message') )
                                <div class="ui ignored negative message">
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                            <div class="field">
                                <input type="text" placeholder="Username" name="Username">
                            </div>
                            <div class="field">
                                <input type="password" placeholder="Password" name="Password">
                            </div>
                            <div class="field">
                                <input type="submit" value="sign in" class="ui button large fluid blue">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        @section('js')


        @endsection
    </div>



@endsection
