@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://cdn.discordapp.com/attachments/1306166047271030814/1308041469910843432/chezleo.png?ex=67470c0c&is=6745ba8c&hm=67f7e69be5786a24f6a4a21c1dc2957eaa33aeb5de0cb85afb460961a222791f&" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
