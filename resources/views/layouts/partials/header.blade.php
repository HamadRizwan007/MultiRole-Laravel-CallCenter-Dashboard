<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <svg class="c-icon c-icon-lg">
            <use xlink:href="{{asset('svg_sprites/free.svg#cil-menu')}}"></use>
        </svg>
    </button>
    <a class="c-header-brand d-lg-none pt-4" href="{{ route('home') }}">
        <img src="{{ asset('img/logo-w.png') }}" alt="{{ config('app.name') }}" style="max-height: 85px; max-width: 120px;">
    </a>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <svg class="c-icon c-icon-lg">
            <use xlink:href="{{asset('svg_sprites/free.svg#cil-menu')}}"></use>
        </svg>
    </button>
    <ul class="c-header-nav d-md-down-none">
        <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="{{route('home')}}">Dashboard</a></li>
        {{-- <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Settings</a></li> --}}
    </ul>
    <ul class="c-header-nav mx-auto pl-5">
        @role('client')
        <li class="c-header-nav-item ml-5 pl-5">
            Manual Lead Acceptance Status:
            @if(auth()->user()->lead_accept_status == 2)
                <span class="badge badge-success lead-accept-btn" data-toggle="modal" data-target="#updateSelfLeadAcceptStatus">
                    {{ auth()->user()->lead_accept_status_text }}
                </span>
            @endif
            @if(auth()->user()->lead_accept_status == 1)
                <span class="badge badge-danger lead-accept-btn" data-toggle="modal" data-target="#updateSelfLeadAcceptStatus">
                    {{ auth()->user()->lead_accept_status_text }}
                </span>
            @endif
        </li>
        @if(auth()->user()->client_timetable)
            <li class="c-header-nav-item ml-5 pl-5">
                Timetable Lead Acceptance Status:
                @if(auth()->user()->currently_accepting_leads)
                    <span class="badge badge-success lead-accept-btn">
                        Active
                    </span>
                @else
                <span class="badge badge-danger lead-accept-btn">
                    Paused
                </span>
                @endif
            </li>
        @endif
        @endrole
    </ul>
    <ul class="c-header-nav ml-auto mr-4">
        <li class="c-header-nav-item dropdown mx-2">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-avatar">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{asset('svg_sprites/free.svg#cil-bell')}}"></use>
                    </svg>
                    <span class="badge badge-danger ml-1 @if(auth()->user()->unreadNotifications->count() == 0) d-none @endif" id="notificationCount">{{ auth()->user()->unreadNotifications->count() }}</span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right py-0" style="min-width: 320px; width: max-content; max-width: 380px;">
                <div class="dropdown-header bg-light py-2 d-flex justify-content-between"><strong>Notifications</strong> @if(auth()->user()->unreadNotifications->count() > 0)<button class="btn btn-link p-0" href="{{ route('notification.read-all') }}" onclick="document.getElementById('allReadForm').submit()">Mark all read</button>@endif</div>
                <form action="{{ route('notification.read-all') }}" id="allReadForm" method="POST">
                    @csrf
                </form>

                <div id="notificationContainer">
                    @forelse (auth()->user()->unreadNotifications->take(10) as $notification)
                        <a class="dropdown-item py-2 align-items-start" style="white-space: normal;" href="{{ route('notification.show', ['notification' => $notification]) }}">
                            <svg class="c-icon mr-2" style="width: 2rem; height: 2rem;">
                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-speech')}}"></use>
                            </svg> <span>{!! $notification->data['text'] !!}</span>
                        </a>
                    @empty
                        <div class="dropdown-item py-3">
                            No unread notifications
                        </div>
                    @endforelse
                </div>

                <a class="dropdown-item bg-info text-white mt-1 py-2 d-block text-center" href="{{ route('notification.index') }}">View all</a>
            </div>
        </li>
        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-avatar"><img class="c-avatar-img" src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->initials }}"></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
                <div class="dropdown-header bg-light py-2"><strong>Account</strong></div>
                <a class="dropdown-item" href="{{ route('profile.show') }}">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{asset('svg_sprites/free.svg#cil-user')}}"></use>
                    </svg> Profile
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="dropdown-item" type="submit">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{asset('svg_sprites/free.svg#cil-account-logout')}}"></use>
                        </svg> Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
    @if($breadcrumb)
    <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
            {{ $breadcrumb ?? '' }}
        </ol>
    </div>
    @endif
</header>
@role('client')
<div class="modal fade" id="updateSelfLeadAcceptStatus" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-info" role="document">
        <div class="modal-content">
            <form action="{{ route('client.update-lead-accept-status', auth()->user()) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h4 class="modal-title">Update Lead Accept Status</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="lead_accept_status" value="{{ auth()->user()->lead_accept_status == 2 ? 1:2 }}">
                    Are you sure you wish to update the lead acceptance status to <strong>{{ auth()->user()->lead_accept_status == 2 ? \App\Models\User::$leadAcceptStatuses[1]:\App\Models\User::$leadAcceptStatuses[2] }}</strong>?

                    <div class="mt-2">
                        <strong>Note: </strong> Lead Accept Status also changes based on your timetable.<br>The above status optoin is your manual pause status. This will only overwrite the timetable based status if it is set to paused.
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-info" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endrole
