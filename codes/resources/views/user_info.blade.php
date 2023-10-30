@php
    $user_id =  $content ?? '';
    $user = App\Models\User::find($user_id);
@endphp
<p>{{ $user->name ?? '' }}</p>
<p>{{ $user->email ?? '' }}</p>
<p>{{ $user->mobile ?? '' }}</p>
