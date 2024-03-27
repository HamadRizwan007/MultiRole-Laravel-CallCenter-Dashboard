<x-dashboard-layout>

    <x-slot name="pageTitle">Dashboard</x-slot>



    <x-slot name="breadcrumb">

        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>

        <li class="breadcrumb-item active">Dashboard</li>

    </x-slot>



    <x-slot name="scripts">

        <script>
            $("#latestLeadsTable").DataTable();
        </script>

    </x-slot>



    <div>

        @if(auth()->user()->hasAnyRole('admin'))

        <div class="row">

            <div class="col-6 col-lg-3">

                <div class="card">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="bg-primary p-3 mfe-3">

                            <svg class="c-icon c-icon-xl">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-briefcase')}}"></use>

                            </svg>

                        </div>

                        <table>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Total Leads</th>

                                <td class="text-value text-primary pl-4">{{ $counts['total_leads'] }}</td>

                            </tr>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Un-assigned Leads</th>

                                <td class="text-value text-primary pl-4">{{ $counts['un_assigned_leads'] }}</td>

                            </tr>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Rejected Leads</th>

                                <td class="text-value text-primary pl-4">{{ $counts['rejected_leads'] }}</td>

                            </tr>

                        </table>

                    </div>

                    <div class="card-footer px-3 py-2">

                        <a class="btn-block text-muted d-flex justify-content-between align-items-center"
                            href="{{ route('leads.index') }}"><span class="small font-weight-bold">View More</span>

                            <svg class="c-icon">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-chevron-right')}}"></use>

                            </svg>

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-6 col-lg-3">

                <div class="card">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="bg-warning p-3 mfe-3">

                            <svg class="c-icon c-icon-xl">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-address-book')}}"></use>

                            </svg>

                        </div>

                        <table>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Total Call Center</th>

                                <td class="text-value text-primary pl-4">{{ $counts['total_centers'] }}</td>

                            </tr>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Active Call Centers</th>

                                <td class="text-value text-primary pl-4">{{ $counts['active_centers'] }}</td>

                            </tr>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Blocked Call Centers</th>

                                <td class="text-value text-primary pl-4">{{ $counts['inactive_centers'] }}</td>

                            </tr>

                        </table>

                    </div>

                    <div class="card-footer px-3 py-2">

                        <a class="btn-block text-muted d-flex justify-content-between align-items-center"
                            href="{{ route('call-center.index') }}"><span class="small font-weight-bold">View
                                More</span>

                            <svg class="c-icon">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-chevron-right')}}"></use>

                            </svg>

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-6 col-lg-3">

                <div class="card">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="bg-info p-3 mfe-3">

                            <svg class="c-icon c-icon-xl">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-user')}}"></use>

                            </svg>

                        </div>

                        <table>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Total Clients</th>

                                <td class="text-value text-primary pl-4">{{ $counts['total_clients'] }}</td>

                            </tr>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Active Clients</th>

                                <td class="text-value text-primary pl-4">{{ $counts['active_clients'] }}</td>

                            </tr>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Blocked Clients</th>

                                <td class="text-value text-primary pl-4">{{ $counts['inactive_clients'] }}</td>

                            </tr>

                        </table>

                    </div>

                    <div class="card-footer px-3 py-2">

                        <a class="btn-block text-muted d-flex justify-content-between align-items-center"
                            href="{{ route('client.index') }}"><span class="small font-weight-bold">View More</span>

                            <svg class="c-icon">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-chevron-right')}}"></use>

                            </svg>

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-6 col-lg-3">

                <div class="card">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="bg-danger p-3 mfe-3">

                            <svg class="c-icon c-icon-xl">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-warning')}}"></use>

                            </svg>

                        </div>

                        <div>

                            <div class="text-value text-danger">{{ $counts['tickets'] }}</div>

                            <div class="text-muted text-uppercase font-weight-bold small">Support Tickets</div>

                        </div>

                    </div>

                    <div class="card-footer px-3 py-2">

                        <a class="btn-block text-muted d-flex justify-content-between align-items-center"
                            href="{{ route('tickets.index') }}"><span class="small font-weight-bold">View More</span>

                            <svg class="c-icon">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-chevron-right')}}"></use>

                            </svg>

                        </a>

                    </div>

                </div>

            </div>

        </div>

        @endif

        @if(auth()->user()->hasAnyRole('client broker'))

        <div class="row">

            <div class="col-6 col-lg-3">

                <div class="card">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="bg-primary p-3 mfe-3">

                            <svg class="c-icon c-icon-xl">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-briefcase')}}"></use>

                            </svg>

                        </div>

                        <table>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Total Leads</th>

                                <td class="text-value text-primary pl-4">{{ $counts['total_leads'] }}</td>

                            </tr>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Billable Leads</th>

                                <td class="text-value text-primary pl-4">{{ $counts['billable_leads'] }}</td>

                            </tr>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Rejected Leads</th>

                                <td class="text-value text-primary pl-4">{{ $counts['rejected_leads'] }}</td>

                            </tr>

                        </table>

                    </div>

                    <div class="card-footer px-3 py-2">

                        <a class="btn-block text-muted d-flex justify-content-between align-items-center"
                            href="{{ route('leads.index') }}"><span class="small font-weight-bold">View More</span>

                            <svg class="c-icon">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-chevron-right')}}"></use>

                            </svg>

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-6 col-lg-3">

                <div class="card">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="bg-info p-3 mfe-3">

                            <svg class="c-icon c-icon-xl">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-user')}}"></use>

                            </svg>

                        </div>

                        <table>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Total Clients</th>

                                <td class="text-value text-primary pl-4">{{ $counts['total_clients'] }}</td>

                            </tr>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Active Clients</th>

                                <td class="text-value text-primary pl-4">{{ $counts['active_clients'] }}</td>

                            </tr>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">InActive Clients</th>

                                <td class="text-value text-primary pl-4">{{ $counts['inactive_clients'] }}</td>

                            </tr>

                        </table>

                    </div>

                    <div class="card-footer px-3 py-2">

                        <a class="btn-block text-muted d-flex justify-content-between align-items-center"
                            href="{{ route('client.index') }}"><span class="small font-weight-bold">View More</span>

                            <svg class="c-icon">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-chevron-right')}}"></use>

                            </svg>

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-6 col-lg-3">

                <div class="card">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="bg-warning p-3 mfe-3">

                            <svg class="c-icon c-icon-xl">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-address-book')}}"></use>

                            </svg>

                        </div>

                        <table>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Total Agent</th>

                                <td class="text-value text-primary pl-4">{{ $counts['total_agents'] }}</td>

                            </tr>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">Active Agents</th>

                                <td class="text-value text-primary pl-4">{{ $counts['active_agents'] }}</td>

                            </tr>

                            <tr>

                                <th class="text-muted text-uppercase font-weight-bold small">In-Active Agents</th>

                                <td class="text-value text-primary pl-4">{{ $counts['inactive_agents'] }}</td>

                            </tr>

                        </table>

                    </div>

                    <div class="card-footer px-3 py-2">

                        <a class="btn-block text-muted d-flex justify-content-between align-items-center"
                            href="{{ route('client-agent.index') }}"><span class="small font-weight-bold">View
                                More</span>

                            <svg class="c-icon">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-chevron-right')}}"></use>

                            </svg>

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-6 col-lg-3">

                <div class="card">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="bg-danger p-3 mfe-3">

                            <svg class="c-icon c-icon-xl">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-warning')}}"></use>

                            </svg>

                        </div>

                        <div>

                            <div class="text-value text-danger">{{ $counts['tickets'] }}</div>

                            <div class="text-muted text-uppercase font-weight-bold small">Support Tickets</div>

                        </div>

                    </div>

                    <div class="card-footer px-3 py-2">

                        <a class="btn-block text-muted d-flex justify-content-between align-items-center"
                            href="{{ route('tickets.index') }}"><span class="small font-weight-bold">View More</span>

                            <svg class="c-icon">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-chevron-right')}}"></use>

                            </svg>

                        </a>

                    </div>

                </div>

            </div>

        </div>

        @endif

        @if(auth()->user()->hasRole('client') || auth()->user()->hasRole('client manager'))

        <div class="row">

            <div class="col-6 col-lg-3">

                <div class="card">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="bg-primary p-3 mfe-3">

                            <svg class="c-icon c-icon-xl">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-briefcase')}}"></use>

                            </svg>

                        </div>

                        <div>

                            <div class="text-value text-primary">{{ $counts['leads'] }}</div>

                            <div class="text-muted text-uppercase font-weight-bold small">Leads</div>

                        </div>

                    </div>

                    <div class="card-footer px-3 py-2">

                        <a class="btn-block text-muted d-flex justify-content-between align-items-center"
                            href="{{ route('leads.index') }}"><span class="small font-weight-bold">View More</span>

                            <svg class="c-icon">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-chevron-right')}}"></use>

                            </svg>

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-6 col-lg-3">

                <div class="card">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="bg-warning p-3 mfe-3">

                            <svg class="c-icon c-icon-xl">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-briefcase')}}"></use>

                            </svg>

                        </div>

                        <div>

                            <div class="text-value text-warning">{{ $counts['managers'] }}</div>

                            <div class="text-muted text-uppercase font-weight-bold small">Managers</div>

                        </div>

                    </div>

                    <div class="card-footer px-3 py-2">

                        <a class="btn-block text-muted d-flex justify-content-between align-items-center"
                            href="{{ route('client-manager.index') }}"><span class="small font-weight-bold">View
                                More</span>

                            <svg class="c-icon">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-chevron-right')}}"></use>

                            </svg>

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-6 col-lg-3">

                <div class="card">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="bg-info p-3 mfe-3">

                            <svg class="c-icon c-icon-xl">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-user')}}"></use>

                            </svg>

                        </div>

                        <div>

                            <div class="text-value text-info">{{ $counts['agents'] }}</div>

                            <div class="text-muted text-uppercase font-weight-bold small">Agents</div>

                        </div>

                    </div>

                    <div class="card-footer px-3 py-2">

                        <a class="btn-block text-muted d-flex justify-content-between align-items-center"
                            href="{{ route('client-agent.index') }}"><span class="small font-weight-bold">View
                                More</span>

                            <svg class="c-icon">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-chevron-right')}}"></use>

                            </svg>

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-6 col-lg-3">

                <div class="card">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="bg-danger p-3 mfe-3">

                            <svg class="c-icon c-icon-xl">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-warning')}}"></use>

                            </svg>

                        </div>

                        <div>

                            <div class="text-value text-danger">{{ $counts['tickets'] }}</div>

                            <div class="text-muted text-uppercase font-weight-bold small">Support Tickets</div>

                        </div>

                    </div>

                    <div class="card-footer px-3 py-2">

                        <a class="btn-block text-muted d-flex justify-content-between align-items-center"
                            href="{{ route('tickets.index') }}"><span class="small font-weight-bold">View More</span>

                            <svg class="c-icon">

                                <use xlink:href="{{asset('svg_sprites/free.svg#cil-chevron-right')}}"></use>

                            </svg>

                        </a>

                    </div>

                </div>

            </div>

        </div>

        @endif

        <div class="row mb-4">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">

                        <h3>Recent Leads</h3>

                    </div>

                    <div class="card-body">

                        <table class="table table-striped table-responsive-sm table-hover table-outline mb-0"
                            id="latestLeadsTable">

                            <thead class="thead-dark" style="border-color: var(--info);">

                                <tr>

                                    <th class="bg-info">Sr. #</th>

                                    <th class="bg-info">State</th>

                                    @if(auth()->user()->hasAnyRole(['admin', 'agent', 'call center', 'client broker']))

                                    <th class="bg-info">Client</th>

                                    @endif

                                    <th class="bg-info">Contact</th>

                                    <th class="bg-info">Quote Type</th>

                                    <th class="bg-info">Assign Type</th>

                                    <th class="bg-info">Agent/Center</th>

                                    <th class="bg-info">Created At</th>

                                    <th class="bg-info">Attached At</th>

                                    <th class="bg-info">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse ($leads as $lead)

                                <tr
                                    style="@if(!$lead->client) background: #fff6cf; color: #7A6A38; @endif @if($lead->status == '4')  background-color: #eb7a7a; color: #fff; @endif">

                                    <td>{{ $loop->index + 1 }}</td>

                                    <td>{{ ucwords($lead->state) }}</td>

                                    @if(auth()->user()->hasAnyRole(['admin', 'agent', 'call center', 'client broker']))

                                    <td>

                                        @if(auth()->user()->hasAnyRole(['admin', 'client broker']))

                                        @if($lead->client)

                                        <a href="{{ route('client.show', $lead->client) }}">

                                            {{ $lead->client->name }}

                                        </a>

                                        <div class="text-muted">{{ $lead->client->uid }}</div>

                                        @else

                                        NA

                                        @endif

                                        @else

                                        {{ $lead->client->uid ?? 'NA' }}

                                        @endif

                                    </td>

                                    @endif

                                    <td>

                                        {{ $lead->name }}

                                        <div><strong>Phone: </strong> {{ $lead->phone }}</div>

                                    </td>

                                    <td>{{ ucwords($lead->quote_type) }}</td>

                                    <td>{{ ucwords($lead->assign_type_text) }}</td>

                                    <td>

                                        <div><strong>Agent:</strong> @if(auth()->user()->hasAnyRole(['admin', 'call
                                            center', 'agent'])) {{ $lead->agent->name }} @else {{ $lead->agent_id }}
                                            @endif</div>

                                        <div><strong>Center:</strong> @if(auth()->user()->hasAnyRole(['admin', 'call
                                            center', 'agent'])) {{ $lead->call_center->center_name }} @else
                                            {{ $lead->call_center_id }} @endif</div>

                                    </td>

                                    <td>{!! $lead->created_at->setTimezone(auth()->user()->timezone)->format('d M Y\
                                        <\b\r\>h:i:s A') !!}</td>

                                    <td>{!! $lead->assigned_time ?
                                        $lead->assigned_time->setTimezone(auth()->user()->timezone)->format('d M Y\
                                        <\b\r\>h:i:s A') : 'NA' !!}</td>

                                    <td><a href="{{ route('leads.show', $lead) }}" class="btn btn-primary">View</a></td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="10" class="text-center">No Leads to show</td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        @can('view all users')

        <div class="row">

            <div class="col-md-6">

                <div class="card">

                    <div class="card-header bg-light font-weight-bold">Recent Registrations</div>

                    <div class="card-body p-0" style="position: relative; max-height: 680px; overflow: auto;">

                        <table class="table table-responsive-sm table-striped table-hover table-outline mb-0">

                            <thead>

                                <tr>

                                    <th class="text-center">

                                        <svg class="c-icon">

                                            <use xlink:href="{{asset('svg_sprites/free.svg#cil-people')}}"></use>

                                        </svg>

                                    </th>

                                    <th>User</th>

                                    <th>Role(s)</th>

                                    <th>Activity</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($recent_users as $user)

                                <tr>

                                    <td class="text-center">

                                        <div class="c-avatar">

                                            <img class="c-avatar-img" src="{{ $user->avatar_url }}"
                                                alt="{{ $user->email }}">

                                        </div>

                                    </td>

                                    <td>

                                        @php

                                        $profile_route = '#';

                                        if($user->hasRole('admin')){

                                        $profile_route = '#';

                                        } else if($user->hasRole('client')){

                                        $profile_route = route('client.show', $user);

                                        } else if($user->hasRole('client agent')){

                                        $profile_route = route('client-agent.show', $user);

                                        } else if($user->hasRole('call center')){

                                        $profile_route = route('call-center.show', $user);

                                        } else if($user->hasRole('agent')){

                                        $profile_route = route('agent.show', $user);

                                        }

                                        @endphp

                                        <div><a href="{{ $profile_route }}">{{ ucwords($user->name) }}</a></div>

                                        <div class="text-muted">{{ $user->email }}</div>

                                    </td>

                                    <td>{{ ucwords(implode(", ", $user->getRoleNames()->toArray())) }}</td>

                                    <td>

                                        <div class="small text-muted">Registered At</div>

                                        <strong>

                                            {{ $user->created_at->diffForHumans(now()) }}

                                        </strong>

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card">

                    <div class="card-header bg-light font-weight-bold">Recent Logins</div>

                    <div class="card-body p-0" style="position: relative; max-height: 680px; overflow: auto;">

                        <table class="table table-responsive-sm table-striped table-hover table-outline mb-0">

                            <thead>

                                <tr>

                                    <th class="text-center">

                                        <svg class="c-icon">

                                            <use xlink:href="{{asset('svg_sprites/free.svg#cil-people')}}"></use>

                                        </svg>

                                    </th>

                                    <th>User</th>

                                    <th>Role(s)</th>

                                    <th>Activity</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($recent_logins as $user)

                                <tr>

                                    <td class="text-center">

                                        <div class="c-avatar">

                                            <img class="c-avatar-img" src="{{ $user->avatar_url }}"
                                                alt="{{ $user->email }}">

                                        </div>

                                    </td>

                                    <td>

                                        @php

                                        $profile_route = '#';

                                        if($user->hasRole('admin')){

                                        $profile_route = '#';

                                        } else if($user->hasRole('client')){

                                        $profile_route = route('client.show', $user);

                                        } else if($user->hasRole('client agent')){

                                        $profile_route = route('client-agent.show', $user);

                                        } else if($user->hasRole('call center')){

                                        $profile_route = route('call-center.show', $user);

                                        } else if($user->hasRole('agent')){

                                        $profile_route = route('agent.show', $user);

                                        }

                                        @endphp

                                        <div><a href="{{ $profile_route }}">{{ ucwords($user->name) }}</a></div>

                                        <div class="text-muted">{{ $user->email }}</div>

                                    </td>

                                    <td>{{ ucwords(implode(", ", $user->getRoleNames()->toArray())) }}</td>

                                    <td>

                                        <div class="small text-muted">Last Login</div>

                                        <strong>

                                            @if ($user->last_login_time)

                                            {{ $user->last_login_time->diffForHumans(now()) }}

                                            @else

                                            NA

                                            @endif

                                        </strong>

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        @endcan

    </div>

</x-dashboard-layout>