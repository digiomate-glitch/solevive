<x-mail::message>
# Hello {{ $inquiry->name }},

Thank you for contacting Solvive Travel.

{!! nl2br(e($replyMessage)) !!}

<br>
Best regards,<br>
{{ config('app.name') }}
</x-mail::message>
