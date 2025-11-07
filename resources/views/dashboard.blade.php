@extends("Layout.main")
@section("title","Dashboard")
@section("content")
   <div class="container">
        <div class="header">
            <h1>DASHBOARD</h1>
        </div>
        <div class="card1">
            <div class="card-header">
                <h2>Welcome {{ $user->name ?? 'Guest' }} !</h2>
            </div>
            <div class="card2">
                 <div class="card text-white bg-success mb-3" style="max-width: 18rem; border:none;">
                    <div class="card-body">
                        <h5 class="card-title">TOTAL USERS</h5>
                        <h2 class="card-text">{{ $responder }}</h2>
                    </div>
                    </div>
            </div>
        </div>
   </div>
@endsection