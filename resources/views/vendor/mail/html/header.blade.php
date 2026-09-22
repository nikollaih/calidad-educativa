@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('imagenes/educacion_menu-nobg.png') }}" class="logo" alt="Secretaria de Educación" style="max-height: 75px; width: auto;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
