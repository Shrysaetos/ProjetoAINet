@if ($user->admin == 1)
    <td class="user-is-admin">{{ $user->name}}</td>
@endif
@if ($user->blocked == 1)
    <td class="user-is-blocked">{{ $user->name}}</td>
@endif
@if ($user->blocked == $user->admin)
    <td>{{ $user->name}}</td>
@endif