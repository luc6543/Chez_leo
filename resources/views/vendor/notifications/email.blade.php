<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Welkom!')
@endif
@endif

{{-- Intro --}}
{{ $line = "Heel erg bedankt voor uw reservering!
    U hebt deze mail ontvangen om uw eigen wachtwoord aan te maken voor uw account.
    De link verloopt over een uur." }}


{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
    ?>
<x-mail::button :url="$actionUrl" :color="$color">
    {{ $actionText = "Verifieer account"}}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
{{$line = "Als u deze mail ontvangt zonder iets te hebben gedaan,
    neem dan contact met ons op via +31 06 345 67890"}}

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Met vriendelijke groeten,')<br>
Chez Leo
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Als u problemen hebt met het klikken op de \":actionText\" knop, kopier en plak de URL\n".
    'van hier :',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
