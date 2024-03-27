<x-dashboard-layout>
    <x-slot name="pageTitle">Call Center Profile</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('call-center.index') }}">Call Centers</a></li>
        <li class="breadcrumb-item active">Show</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allAgents').DataTable();

                new SlimSelect({
                    select: "#agent",
                    placeholder: 'Select agent',
                })

            });
        </script>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div class="w-50">
                        <img class="c-avatar-img" src="{{ $call_center->avatar_url }}" alt="{{ ucfirst($call_center->name) }}">
                    </div>
                    <h1 class="mt-2">{{ $call_center->center_name }}</h1>
                    <p><strong>Email: </strong><a href="mailto:{{ $call_center->email }}">{{ $call_center->email }}</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <table class="table table-striped table-responsive-md">
                        <tr>
                            <th>Owner Name</th>
                            <td>{{ $call_center->name }}</td>
                        </tr>
                        <tr>
                            <th>Center Name</th>
                            <td>{{ $call_center->center_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $call_center->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $call_center->phone ?? 'NA' }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $call_center->full_address }}</td>
                        </tr>
                        <tr>
                            <th>Registered At</th>
                            <td>{{ $call_center->created_at->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2 class="h3">Agents</h2>
                    <div>
                        <button class="btn btn-success" data-toggle="modal" data-target="#attachAgentToCallCenter">Attach Agent</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="allAgents" class="table table-striped table-responsive-lg" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr #</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                @if(auth()->user()->hasRole('admin'))<th>Registered by</th>@endif
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($call_center->agents as $agent)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $agent->name }}</td>
                                    <td>{{ $agent->email }}</td>
                                    <td>{{ $agent->phone ?? "NA" }}</td>
                                    @if(auth()->user()->hasRole('admin'))
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
                                    @endif
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
                                            <a class="btn btn-info" href="{{ route('agent.show', $agent) }}">Profile</a>
                                            <button class="btn btn-danger" data-toggle="modal" data-target="#removeAgentFromCallCenter_{{ $agent->id }}">Remove From Call Center</button>
                                        </div>
                                        <div class="btn-group" role="group" aria-label="User Status Actions">
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="attachAgentToCallCenter" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-success" role="document">
            <div class="modal-content">
                <form action="{{ route('call-center.attach-agent', $call_center) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h4 class="modal-title">Attach Agent to Call Center</h4>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="agent">Select Agent</label>
                            <select name="agent" id="agent">
                                <option value="">Select new agent to attach to broker</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }} - {{ $agent->email }}</option>
                                @endforeach
                            </select>
                            @error('agent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-success" type="submit">Confirm Attach</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($call_center->agents as $agent)
        <div class="modal fade" id="removeAgentFromCallCenter_{{ $agent->id }}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form action="{{ route('call-center.remove-agent', $agent) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header">
                            <h4 class="modal-title">Confirm remove Agent from call center?</h4>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                Are you sure you wish to remove the client with name [{{ $agent->name }}] form this broker?
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                            <button class="btn btn-danger" type="submit">Confirm Remove</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
    @endforeach
</x-dashboard-layout>
