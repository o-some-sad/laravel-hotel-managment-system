<h1>Managers List</h1>
@if(auth()->user()->hasRole('Admin'))
    <p>You are Admin</p>
@endif