<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{Request::is('home') ? 'active' : ''}}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>

</li>
<li class="nav-item">
    <a href="{{ route('icon.index') }}" class="nav-link {{Request::is('icon/*') || Request::is('icon') ? 'active' : ''}}">
        <i class="nav-icon fas fa-icons"></i>
        <p>Icons</p>
    </a>
</li>
<li class="nav-item menu-is-opening menu-open">
    <a href="#" class="nav-link {{Request::is('team/*') || Request::is('team') || Request::is('member/*') || Request::is('member') ? 'active' : ''}}">
        <i class="nav-icon fas fa-user-cog"></i>
        <p>
            Team & Members
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: block;">
        <li class="nav-item">
            <a href="{{ route('team.index') }}" class="nav-link {{Request::is('team/*') || Request::is('team') ? 'active' : ''}}">
                <i class="fas fa-user-friends nav-icon"></i>
                <p>Team</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('member.index') }}" class="nav-link {{Request::is('member/*') || Request::is('member') ? 'active' : ''}}">
                <i class="fas fa-user nav-icon"></i>
                <p>Members</p>
            </a>
        </li>

    </ul>
</li>