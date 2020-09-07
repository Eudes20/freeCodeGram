@component('mail::message')
# Welcome to freecodeGram

This is a community of fellow developers and we love that you joined us.

@component('mail::button', ['url' => 'http://127.0.0.1:8000/'])
freeCodeGram
@endcomponent

All the best,<br>
{{ config('app.name') }}
@endcomponent
