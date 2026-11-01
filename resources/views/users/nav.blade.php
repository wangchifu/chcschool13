<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ $active[1] }}" href="{{ route('users.index') }}">在職教職</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ $active[2] }}" href="{{ route('users.leave') }}">離職教職</a>
    </li>
</ul>