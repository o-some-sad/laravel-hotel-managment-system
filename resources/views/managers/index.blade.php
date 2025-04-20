<h1>Managers List</h1>
@if(auth()->user()->hasRole('admin'))
    <p>You are admin</p>
@endif