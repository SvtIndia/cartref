<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
            @else
                <img
                    src="{{ Voyager::image('images/showroom_at_home.png') }}"
                    style="width: 200px;background: black;padding: 15px;border-radius: 2px;"
                    class="logo"
                    alt="Cartref Logo"
                >
                <br>
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
