<x-dashboard-layout>
    @if(auth()->user()->can('view all users'))
        <x-slot name="pageTitle">{{ucwords(request()->status ?? 'All')}} Agents</x-slot>
    @else
        <x-slot name="pageTitle">My Agents</x-slot>
    @endif

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client-agent.index') }}">Agents</a></li>
        @if(auth()->user()->can('view all users'))
            <li class="breadcrumb-item active">{{ucwords(request()->status ?? 'All')}}</li>
        @else
            @if (auth()->user()->hasRole('client broker'))
                <li class="breadcrumb-item active">{{ucwords(request()->status ?? 'All')}} Client Agents</li>
            @else
                <li class="breadcrumb-item active">{{ucwords(request()->status ?? 'All')}}</li>
            @endif
        @endif
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allAgents').DataTable();

                @foreach ($agents as $agent)
                    @if(in_array($agent->status, [1,2]))
                        @if($agent->client)
                            new SlimSelect({select: "#updateClientSelect_{{ $agent->id }}"});
                        @else
                            new SlimSelect({select: "#attachClientSelect_{{ $agent->id }}"});
                        @endif
                    @endif
                @endforeach
            });
        </script>
    </x-slot>

    <div>
        <div class="card">
            <div class="card-body">
                <table id="allAgents" class="table table-striped table-responsive-lg" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Name</th>
                            @if(auth()->user()->can('view all users'))
                                <th>Client</th>
                            @else
                                <th>Phone</th>
                            @endif
                            <th>Registered by</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agents as $agent)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    {{ $agent->name }}
                                    <div class="text-muted">{{ $agent->email }}</div>
                                </td>
                                @if(auth()->user()->can('view all users'))
                                    <td>
                                        @if($agent->client)
                                            {{ ucfirst($agent->client->name) }}
                                        @else
                                            @if($agent->client_id)
                                                Deleted
                                            @else
                                                NA
                                            @endif
                                        @endif
                                    </td>
                                @else
                                    <td>{{ $agent->phone ?? 'NA' }}</td>
                                @endif
                                <td>
                                    @if($agent->created_by)
                                        {{ $agent->created_by->name }}
                                    @else
                                        @if($agent->created_by_id)
                                            Deleted
                                        @else
                                            Self Register
                                        @endif
                                    @endif
                                </td>
                                <td style="font-size: 1rem;" data-order="{{ $agent->status }}">
                                    @php
                                        $class_name = 'badge-info';
                                        switch ($agent->status) {
                                            case 1:
                                                $class_name = 'badge-warning text-white';
                                                break;
                                            case 2:
                                                $class_name = 'badge-success text-white';
                                                break;
                                            case 3:
                                                $class_name = 'badge-danger text-white';
                                                break;
                                            case 4:
                                                $class_name = 'badge-secondary';
                                                break;
                                        }
                                    @endphp
                                    <span class="badge {{ $class_name }}">{{ ucfirst($agent->status_text) }}</span>
                                </td>
                                @if ($agent->last_login_time)
                                    <td data-order="{{ $agent->last_login_time->setTimezone(auth()->user()->timezone)->getTimestamp() }}">
                                        {{ $agent->last_login_time->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}
                                    </td>
                                @else
                                    <td data-order="{{ now()->addDay()->getTimestamp() }}">
                                        NA
                                    </td>
                                @endif
                                <td>
                                    <div class="btn-group" role="group" aria-label="User actions">
                                        <a class="btn btn-info" href="{{ route('client-agent.show', $agent) }}">Profile</a>
                                        @if(auth()->user()->can('update client agent info') && $agent->status == 2)
                                            <a class="btn btn-warning" href="{{ route('client-agent.edit', $agent) }}">Edit</a>
                                        @endif
                                        @if(($agent->status == 1 || $agent->status == 2) && auth()->user()->hasAnyRole(['admin', 'client broker']))
                                            @if($agent->client)
                                                <button class="btn btn-primary" type="button"  data-toggle="modal" data-target="#updateClient_{{$agent->id}}">Update Client</button>
                                            @else
                                                <button class="btn btn-primary" type="button"  data-toggle="modal" data-target="#attachClient_{{$agent->id}}">Attach Client</button>
                                            @endif
                                        @endif
                                        @if($agent->status == 2 && auth()->user()->can('view all users'))
                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#blockUser_{{$agent->id}}">Block</button>
                                        @endif
                                        @if($agent->status == 3 && auth()->user()->can('view all users'))
                                            <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#activateUser_{{$agent->id}}">Activate</button>
                                        @endif
                                        @if($agent->status == 4 && auth()->user()->can('view all users'))
                                            <button class="btn btn-warning" type="button"  data-toggle="modal" data-target="#unBlockUser_{{$agent->id}}">Un-block</button>
                                        @endif
                                    </div>
                                    @if($agent->status == 1 && auth()->user()->can('view all users'))
                                    <div>
                                        <div class="mt-2 btn-group" role="group" aria-label="Approve or reject agent">
                                            <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#activateUser_{{$agent->id}}">Approve</button>
                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#rejectUser_{{$agent->id}}">Reject</button>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @if(($agent->status == 1 || $agent->status == 3) && auth()->user()->can('view all users'))
                                <div class="modal fade" id="activateUser_{{$agent->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-danger" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('client-agent.update-status', $agent) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="2">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Are you sure?</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to approve the profile for the agent with name <strong>{{ $agent->name}}</strong>.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                    @if($agent->status == 1)
                                                        <button class="btn btn-danger" type="submit">Approve</button>
                                                    @endif
                                                    @if($agent->status == 3)
                                                        <button class="btn btn-danger" type="submit">Activate</button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($agent->status == 1 && auth()->user()->can('view all users'))
                                <div class="modal fade" id="rejectUser_{{$agent->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-danger" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('client-agent.update-status', $agent) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="4">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirm reject agent?</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to reject the agent with name <strong>{{ $agent->name}}</strong>.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                    <button class="btn btn-danger" type="submit">Reject</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($agent->status == 2 && auth()->user()->can('view all users'))
                                <div class="modal fade" id="blockUser_{{$agent->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-danger" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('client-agent.update-status', $agent) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="4">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirm Block User?</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to block the with name <strong>{{ $agent->name}}</strong>.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                    <button class="btn btn-danger" type="submit">Block</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($agent->status == 4 && auth()->user()->can('view all users'))
                                <div class="modal fade" id="unBlockUser_{{$agent->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-danger" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('client-agent.update-status', $agent) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="2">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirm Un-block User?</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to un-block the agent with name <strong>{{ $agent->name}}</strong>.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                    <button class="btn btn-danger" type="submit">Un-block</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(($agent->status == 1 || $agent->status == 2) && auth()->user()->hasAnyRole(['admin', 'client broker']))
                                @if($agent->client)
                                    <div class="modal fade" id="updateClient_{{$agent->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                        <div class="modal-dialog modal-primary" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('client-agent.update-client', $agent) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="2">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Update the agent's client</h4>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="client" style="font-size: 1.1em; margin-bottom: .5rem; display: block;">Attach Client</label>
                                                            <select name="client" id="updateClientSelect_{{ $agent->id }}" required>
                                                                <option value="">Select a new client for the agent</option>
                                                                @foreach ($clients->where('id', '!=', $agent->client->id) as $client)
                                                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('client')
                                                                <div class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-success" type="submit">Update Client</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="modal fade" id="attachClient_{{$agent->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                        <div class="modal-dialog modal-primary" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('client-agent.update-client', $agent) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="2">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Attach Client to agent</h4>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="client" style="font-size: 1.1em; margin-bottom: .5rem; display: block;">Client</label>
                                                            <select name="client" id="attachClientSelect_{{ $agent->id }}">
                                                                <option value="">Select a client for agent</option>
                                                                @foreach ($clients as $client)
                                                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('client')
                                                                <div class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-success" type="submit">Attach Client</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard-layout>
