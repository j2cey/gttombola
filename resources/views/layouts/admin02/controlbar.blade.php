<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        @guest
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        @else
            <h5>{{ Auth::user()->name }}</h5>
            <a class="d-block" href="javascript:{}" onclick="document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </form>
        @endguest
    </div>
</aside>
