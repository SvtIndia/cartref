<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
            @else
                <img
                    src="{{ env('APP_URL') }}/images/showroom_at_home.png"
                    style="width:auto;height: 100px;max-height: 100px;background: black;padding: 15px;border-radius: 2px;"
                    class="logo"
                    alt="Cartref Logo"
                >
                <br>
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
