@component('mail::message')
# New contact message

**From:** {{ $contactMessage->name }}  
**Email:** {{ $contactMessage->email }}  
@if($contactMessage->subject)
**Subject:** {{ $contactMessage->subject }}
@endif

---

{{ $contactMessage->message }}

---

_IP:_ {{ $contactMessage->ip_address ?? 'n/a' }}  
_Sent at:_ {{ $contactMessage->created_at->toDayDateTimeString() }}

@endcomponent
