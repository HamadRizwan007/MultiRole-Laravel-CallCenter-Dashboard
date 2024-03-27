<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <a href="{{ route('home') }}" class="c-sidebar-brand d-lg-down-none" style="padding: 0.5rem;">
        <div class="d-flex flex-column justify-content-center align-items-center py-2">
            <img width="100%" src="{{asset('img/logo-w.png')}}" alt="{{config('app.name')}}" style="max-width: 110px;">

            <div class="mt-2">
                <span class="d-inline-block font-semibold text-center" style="font-size: 0.8rem;">
                    {{ ucwords(auth()->user()->getRoleNames()->first()) }} Dashboard
                </span>
            </div>
        </div>
    </a>
    <ul class="c-sidebar-nav ps ps--active-y">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link @if(request()->routeIs('home')) c-active @endif" href="{{route('home')}}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('svg_sprites/free.svg#cil-speedometer')}}"></use>
                </svg>
                Dashboard
            </a>
        </li>

        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(request()->routeIs('leads.*')) c-show @endif">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('svg_sprites/free.svg#cil-briefcase')}}"></use>
                </svg>Leads
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('view all leads')
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.all_leads') }}"><span class="c-sidebar-nav-icon"></span>All Leads</a></li>
                @endcan
                @can('view own leads')
                    @cannot('view all leads')
                        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.assigned_leads') }}"><span class="c-sidebar-nav-icon"></span>Assigned Leads</a></li>
                    @endcannot
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.created_leads') }}"><span class="c-sidebar-nav-icon"></span>Created Leads</a></li>
                @endcan
                @can('create leads')
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.create') }}"><span class="c-sidebar-nav-icon"></span>Create Lead</a></li>
                @endcan
                @role('admin')
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.trashed') }}"><span class="c-sidebar-nav-icon"></span>Trashed Leads</a></li>
                @endrole
                @if (auth()->user()->hasRole('client'))
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.index') }}"><span class="c-sidebar-nav-icon"></span>All Leads</a></li>
                @endif
                @if (auth()->user()->hasAnyRole(['client agent', 'client manager', 'client broker']))
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.index') }}"><span class="c-sidebar-nav-icon"></span>Client Leads</a></li>
                @endif
                @if (auth()->user()->hasRole('client agent'))
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.client_agent_leads') }}"><span class="c-sidebar-nav-icon"></span>My Leads</a></li>
                @endif
            </ul>
        </li>

        @if(auth()->user()->hasRole(['call center', 'agent']))
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link @if(request()->routeIs('client.public-index')) c-active @endif" href="{{route('client.public-index')}}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{asset('svg_sprites/free.svg#cil-address-book')}}"></use>
                    </svg>
                    Client List
                </a>
            </li>
        @endif

        @canany(['create clients', 'create client agents', 'create client managers', 'create client broker'])
            <li class="c-sidebar-nav-title">Clients</li>
        @endcanany
        @can('create client broker')
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(request()->routeIs('client-broker.*')) c-show @endif">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{asset('svg_sprites/free.svg#cil-book')}}"></use>
                    </svg>Brokers
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client-broker.index') }}"><span class="c-sidebar-nav-icon"></span>All Brokers</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client-broker.index', ['status' => 'active']) }}"><span class="c-sidebar-nav-icon"></span>Active Brokers</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client-broker.index', ['status' => 'inactive']) }}"><span class="c-sidebar-nav-icon"></span>Inactive Brokers</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client-broker.create') }}"><span class="c-sidebar-nav-icon"></span>Create Broker</a></li>
                </ul>
            </li>
        @endcan
        @can('create clients')
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(request()->routeIs('client.*')) c-show @endif">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{asset('svg_sprites/free.svg#cil-address-book')}}"></use>
                    </svg>Individual
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client.index') }}"><span class="c-sidebar-nav-icon"></span>All Individuals</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client.index', ['status' => 'active']) }}"><span class="c-sidebar-nav-icon"></span>Active Individuals</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client.index', ['status' => 'inactive']) }}"><span class="c-sidebar-nav-icon"></span>Inactive Individuals</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client.create') }}"><span class="c-sidebar-nav-icon"></span>Create Individual</a></li>
                </ul>
            </li>
        @endcan

        @can('create client agents')
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(request()->routeIs('client-agent.*')) c-show @endif">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{asset('svg_sprites/free.svg#cil-user')}}"></use>
                    </svg>Agents
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client-agent.index') }}"><span class="c-sidebar-nav-icon"></span>All Agents</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client-agent.index', ['status' => 'active']) }}"><span class="c-sidebar-nav-icon"></span>Active Agents</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client-agent.index', ['status' => 'inactive']) }}"><span class="c-sidebar-nav-icon"></span>Inactive Agents</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client-agent.create') }}"><span class="c-sidebar-nav-icon"></span>Create Agent</a></li>
                </ul>
            </li>
        @endcan

        @can('create client managers')
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(request()->routeIs('client-manager.*')) c-show @endif">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{asset('svg_sprites/free.svg#cil-briefcase')}}"></use>
                    </svg>Managers
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client-manager.index') }}"><span class="c-sidebar-nav-icon"></span>All Managers</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client-manager.index', ['status' => 'active']) }}"><span class="c-sidebar-nav-icon"></span>Active Managers</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client-manager.index', ['status' => 'inactive']) }}"><span class="c-sidebar-nav-icon"></span>Inactive Managers</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('client-manager.create') }}"><span class="c-sidebar-nav-icon"></span>Create Manager</a></li>
                </ul>
            </li>
        @endcan

        @canany(['create centers', 'create agents'])
            <li class="c-sidebar-nav-title">Call Center</li>
        @endcanany
        @can('create centers')
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(request()->routeIs('call-center.*')) c-show @endif">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{asset('svg_sprites/free.svg#cil-phone')}}"></use>
                    </svg>Call Centers
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('call-center.index') }}"><span class="c-sidebar-nav-icon"></span>All Centers</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('call-center.index', ['status' => 'active']) }}"><span class="c-sidebar-nav-icon"></span>Active Centers</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('call-center.index', ['status' => 'inactive']) }}"><span class="c-sidebar-nav-icon"></span>Inactive Centers</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('call-center.create') }}"><span class="c-sidebar-nav-icon"></span>Create Center</a></li>
                </ul>
            </li>
        @endcan

        @can('create agents')
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(request()->routeIs('agent.*')) c-show @endif">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{asset('svg_sprites/free.svg#cil-user')}}"></use>
                    </svg>@if(auth()->user()->hasRole('admin'))Call Center Agents @else Agents @endif
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('agent.index') }}"><span class="c-sidebar-nav-icon"></span>All Agents</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('agent.index', ['status' => 'active']) }}"><span class="c-sidebar-nav-icon"></span>Active Agents</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('agent.index', ['status' => 'inactive']) }}"><span class="c-sidebar-nav-icon"></span>Inactive Agents</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('agent.create') }}"><span class="c-sidebar-nav-icon"></span>Create Agent</a></li>
                </ul>
            </li>
        @endcan

        @canany(['view all agreement', 'view shared agreement', 'create agreement', 'view all document', 'view personal document', 'create document'])
            <li class="c-sidebar-nav-title">Agreements & Documents</li>
            @canany(['view all agreement', 'view shared agreement', 'create agreement'])
                <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(request()->routeIs('agreement.*')) c-show @endif @if(auth()->user()->hasRole('client manager') && !in_array('view agreements', auth()->user()->view_permissions ?? [])) d-none @endif">
                    <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{asset('svg_sprites/free.svg#cil-paperclip')}}"></use>
                        </svg>Agreements
                    </a>
                    <ul class="c-sidebar-nav-dropdown-items">
                        @can('view all agreement')
                            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('agreement.index') }}"><span class="c-sidebar-nav-icon"></span>All Agreements</a></li>
                        @endcan
                        @can('view shared agreement')
                            @if(auth()->user()->hasRole('client'))
                                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('agreement.shared') }}"><span class="c-sidebar-nav-icon"></span>My Agreements</a></li>
                            @endif
                        @endcan
                        @if(auth()->user()->hasRole('client manager') && in_array('view agreements', auth()->user()->view_permissions ?? []))
                            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('agreement.shared') }}"><span class="c-sidebar-nav-icon"></span>Client Agreements</a></li>
                        @endif
                        @can('create agreement')
                            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('agreement.create') }}"><span class="c-sidebar-nav-icon"></span>Create Agreement</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany([ 'view all document', 'view personal document', 'create document'])
                <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(request()->routeIs('document.*')) c-show @endif">
                    <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{asset('svg_sprites/free.svg#cil-description')}}"></use>
                        </svg>Documents
                    </a>
                    <ul class="c-sidebar-nav-dropdown-items">
                        @can('view all document')
                            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('document.index') }}"><span class="c-sidebar-nav-icon"></span>All Documents</a></li>
                        @endcan
                        @can('view personal document')
                            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('document.personal') }}"><span class="c-sidebar-nav-icon"></span>My Documents</a></li>
                        @endcan
                        @can('create document')
                            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('document.create') }}"><span class="c-sidebar-nav-icon"></span>Create Document</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
        @endcanany

        @if (auth()->user()->hasRole('admin'))
            <li class="c-sidebar-nav-title">Analytics</li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('analytics.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{asset('svg_sprites/free.svg#cil-address-book')}}"></use>
                    </svg>Client Leads
                </a>
            </li>
            <li class="c-sidebar-nav-title">Settings</li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(request()->routeIs('state.*')) c-show @endif">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{asset('svg_sprites/free.svg#cil-location-pin')}}"></use>
                    </svg>States
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('state.index') }}"><span class="c-sidebar-nav-icon"></span>All States</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('state.create') }}"><span class="c-sidebar-nav-icon"></span>Create State</a></li>
                </ul>
            </li>
        @endif

        <li class="c-sidebar-nav-title">Support</li>
        @canany(['view all tickets', 'view own tickets'])
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(request()->routeIs('user.*')) c-show @endif">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('svg_sprites/free.svg#cil-warning')}}"></use>
                </svg>Support Tickets
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('view all tickets')
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('tickets.index') }}"><span class="c-sidebar-nav-icon"></span>All Tickets</a></li>
                @endcan
                @can('view own tickets')
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('tickets.my-tickets') }}"><span class="c-sidebar-nav-icon"></span>My Tickets</a></li>
                @endcan
                @can('create tickets')
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('tickets.create') }}"><span class="c-sidebar-nav-icon"></span>Create Ticket</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        <form action="{{ route('logout') }}" method="POST" style="display: inline">
            @csrf
            <li class="c-sidebar-nav-item">
                <button type="submit" class="c-sidebar-nav-link" style="border: 0;">
                    <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('svg_sprites/free.svg#cil-account-logout')}}"></use>
                    </svg> Logout
                </button>
            </li>
        </form>
    </ul>
</div>
