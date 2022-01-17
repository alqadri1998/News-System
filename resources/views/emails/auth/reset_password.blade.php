@component('mail::message')
# Hi {{$adminName}},
# Welcome in News System

Regarding to your request, password has been reset.

@component('mail::panel')
    # Your New Password is:<br>
    {{$newPassword}}
@endcomponent

@component('mail::button', ['url' => 'http://news.mr-tech.tech/cms/admin/login'])
    News System CMS
@endcomponent

Thanks,<br>
# {{ config('app.name') }}
@endcomponent
