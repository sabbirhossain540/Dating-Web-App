<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="http://maps.google.com/maps/api/js"></script>
       <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="{{ asset('js/gmaps.js') }}"></script>
    <style type="text/css">
      #map {
        width: 100%;
        height: 600px;
      }
    </style>

    <title>User View</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span style="color: red;">Dating</span> App
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
</nav>
                @if(session()->has('success'))
                    <script type="text/javascript">
                        $( document ).ready(function() {
                            $('#exampleModal').modal('show');
                        });     
                     </script>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-warning">
                        {{ session()->get('error') }}
                    </div>
                @endif



    <div id="map"></div>
    <br>
    <div class="container">
      <div class="row">

        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              Nearby Person
            </div>
            <div class="card-body">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Profile Picture</th>
                    <th scope="col">Name</th>
                    <th scope="col">Distance</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                    @if(Auth::user()->id != $user->id)
                      <tr>
                        <td><img src="{{ asset('storage/'.$user->image) }}" alt="Card image" width="80px" height="100px"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->distance }} KM</td>
                      </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              Like List
            </div>
            <div class="card-body">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Profile Picture</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user_like_info as $like_info)
                    <tr>
                      <td><img src="{{ asset('storage/'.$like_info->image) }}" alt="Card image" width="80px" height="100px"></td>
                      <td>{{ $like_info->name }}</td>

                      <td>@if($like_info->both_likes == 1)
                            Mutual
                          @else
                            Not Mutual
                          @endif

                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              Dislike List
            </div>
            <div class="card-body">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Distance</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <br><br><br>

    


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Messege</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Congratulations. Both are like each Other
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>






    <script>
    $( document ).ready(function() {
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(function(position){
                var mapObj = new GMaps({
                    el: '#map',
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                    zoom: 13
                  });

                @foreach($users as $user)
                    @if($get_like_infos != null)
                        @foreach($get_like_infos as $get_like_info)
                            var m = mapObj.addMarker({
                              lat: {{ $user->latitude }},
                              lng: {{ $user->langitude }},
                              title:"{{ $user->name }}",
                              @if($get_like_info->profile_id == $user->id)
                                icon: "https://cdn.mapmarker.io/api/v1/font-awesome/v5/pin?icon=fa-star-solid&size=50&hoffset=0&voffset=-1",
                              @endif

                              infoWindow: {
                                content: '<div style="width: 100%; padding-left:50px;"><img src="{{ asset('storage/'.$user->image) }}" alt="Card image" width="70% !important" height="150px"><div class="card-body"><h5 class="card-title">{{ $user->name }}</h5><p class="card-text">Age: {{ $user->age }} years old</p></div><ul class="list-group list-group-flush"><li class="list-group-item">Gander : @if($user->Gander == 0) Male @else Female @endif</li><li class="list-group-item">Distance: {{ $user->distance }} KM</li></ul><div class="card-body">@if(Auth::user()->id != $user->id) @if($get_like_info->profile_id == $user->id)<a href="#" class="card-link"><span style="color:green">Like</span></a> @else <a href="{{ route('likes.edit',$user->id) }}" class="card-link">Like</a> @endif<a href="{{ route('likes.manageDislike',$user->id) }}" class="card-link">Dislike</a>@endif</div></div>',
                                minWidth: 20,
                                maxWidth: 350,
                                minHeight:250,
                              }
                            });

                        @endforeach

                    @else
                        var m = mapObj.addMarker({
                          lat: {{ $user->latitude }},
                          lng: {{ $user->langitude }},
                          title:"{{ $user->name }}",

                          infoWindow: {
                            content: '<div style="width: 100%; padding-left:50px;"><img class="card-img-top" src="{{ asset('storage/'.$user->image) }}" alt="Card image" width="50% !important" height="150px"><div class="card-body"><h5 class="card-title">{{ $user->name }}</h5><p class="card-text">Age: {{ $user->age }} years old</p></div><ul class="list-group list-group-flush"><li class="list-group-item">Gander : @if($user->Gander == 0) Male @else Female @endif</li><li class="list-group-item">Distance: {{ $user->distance }} KM</li><li class="list-group-item"></li></ul><div class="card-body"><a href="{{ route('likes.edit',$user->id) }}" class="card-link">Like</a><a href="#" class="card-link">Dislike</a></div></div>',
                            minWidth: 20,
                            maxWidth: 350,
                            minHeight:200,
                          }
                        });
                    @endif

                @endforeach

            });
        }else{
            console.log("geolocation is not supported");
        }

    });

  </script>

 
  </body>
</html>