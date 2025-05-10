@props(['url'])
<tr>
<td class="header">
<div class="pattern-background"></div>
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src={{ asset("dashboard-assets/img/logo/ilinix-logo.png")}} class="logo" alt="Laravel Logo">
@elseif (trim($slot) === 'Ilinix')
<img src="{{ asset('dashboard-assets/img/logo/ilinix-logo.png') }}" class="logo" alt="Ilinix Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>