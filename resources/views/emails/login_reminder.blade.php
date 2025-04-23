@component('mail::message')
# Hello {{ $user->name }},

We noticed you haven’t logged in for a while, and we just want to say: **We miss you!** ❤️

Come back and check out what’s new at our Hotel!

@component('mail::button', ['url' => url('http://127.0.0.1:8000/login')])
Login Now
@endcomponent

Thanks,<br>
The Team
@endcomponent
