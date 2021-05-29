@component('mail::message')
# Introduction

The body of your message.

Reservation for {{$name}} at {{config('app.name')}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
