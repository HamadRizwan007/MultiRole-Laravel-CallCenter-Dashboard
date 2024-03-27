<x-dashboard-layout>
    <x-slot name="pageTitle">{{ucwords(request()->status ?? 'All')}} Call Centers</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('call-center.index') }}">Call Centers</a></li>
        <li class="breadcrumb-item active">{{ucwords(request()->status ?? 'All')}}</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allCallCenters').DataTable();
            });

            const toggleAgentSelection = () => {
                const all_inputs = document.querySelectorAll("#agentsContainer input[type=\"checkbox\"]");
                const checked_inputs = document.querySelectorAll("#agentsContainer input[type=\"checkbox\"]:checked");

                if(checked_inputs.length < all_inputs.length){
                    all_inputs.forEach(input => { input.checked = true; });
                } else {
                    all_inputs.forEach(input => { input.checked = false; });
                }
            }
        </script>
    </x-slot>

    <div>
        <div class="card">
            <div class="card-body">
                <table id="allCallCenters" class="table table-striped table-responsive-lg" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Owner Name</th>
                            <th>Center Name</th>
                            <th>Phone</th>
                            <th>State</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($call_centers as $call_center)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    {{ $call_center->name }}
                                    <div class="text-muted">{{ $call_center->email }}</div>
                                </td>
                                <td>{{ $call_center->center_name }}</td>
                                <td>{{ $call_center->phone ?? 'NA' }}</td>
                                <td>{{ ucwords($call_center->state) }}</td>
                                <td style="font-size: 1rem;" data-order="{{ $call_center->status }}">
                                    @php
                                        $class_name = 'badge-info';
                                        switch ($call_center->status) {
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
                                    <span class="badge {{ $class_name }}">{{ ucfirst($call_center->status_text) }}</span>
                                </td>
                                @if ($call_center->last_login_time)
                                    <td data-order="{{ $call_center->last_login_time->setTimezone(auth()->user()->timezone)->getTimestamp() }}">
                                        {{ $call_center->last_login_time->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}
                                    </td>
                                @else
                                    <td data-order="{{ now()->addDay()->getTimestamp() }}">
                                        NA
                                    </td>
                                @endif
                                <td>
                                    <div class="btn-group" role="group" aria-label="User actions">
                                        <a class="btn btn-info" href="{{ route('call-center.show', $call_center) }}">Profile</a>
                                        @if(auth()->user()->can('update center info') && $call_center->status == 2)
                                            <a class="btn btn-warning" href="{{ route('call-center.edit', $call_center) }}">Edit</a>
                                        @endif
                                        @if($call_center->status == 2 && auth()->user()->can('view all users'))
                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#blockUser_{{$call_center->id}}">Block</button>
                                        @endif
                                        @if($call_center->status == 3 && auth()->user()->can('view all users'))
                                            <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#activateUser_{{$call_center->id}}">Activate</button>
                                        @endif
                                        @if($call_center->status == 4 && auth()->user()->can('view all users'))
                                            <button class="btn btn-warning" type="button"  data-toggle="modal" data-target="#unBlockUser_{{$call_center->id}}">Un-block</button>
                                        @endif
                                    </div>
                                    @if($call_center->status == 1 && auth()->user()->can('view all users'))
                                    <div>
                                        <div class="mt-2 btn-group" role="group" aria-label="Approve or reject agent">
                                            <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#activateUser_{{$call_center->id}}">Approve</button>
                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#rejectUser_{{$call_center->id}}">Reject</button>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @foreach ($call_centers as $call_center)
                @if(($call_center->status == 1 || $call_center->status == 3) && auth()->user()->can('view all users'))
                    <div class="modal fade" id="activateUser_{{$call_center->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-danger" role="document">
                            <div class="modal-content">
                                <form action="{{ route('call-center.update-status', $call_center) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="2">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Are you sure?</h4>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to approve the profile for the agent with name <strong>{{ $call_center->name}}</strong>.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                        @if($call_center->status == 1)
                                            <button class="btn btn-danger" type="submit">Approve</button>
                                        @endif
                                        @if($call_center->status == 3)
                                            <button class="btn btn-danger" type="submit">Activate</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                @if($call_center->status == 1 && auth()->user()->can('view all users'))
                    <div class="modal fade" id="rejectUser_{{$call_center->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-danger" role="document">
                            <div class="modal-content">
                                <form action="{{ route('call-center.update-status', $call_center) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="4">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirm reject agent?</h4>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to reject the agent with name <strong>{{ $call_center->name}}</strong>.</p>
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
                @if($call_center->status == 2 && auth()->user()->can('view all users'))
                    <div class="modal fade" id="blockUser_{{$call_center->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-danger" role="document">
                            <div class="modal-content">
                                <form action="{{ route('call-center.update-status', $call_center) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="4">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirm Block User?</h4>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to block the with name <strong>{{ $call_center->name}}</strong>.</p>
                                        <p><em>Note: </em> All call center agents will also be blocked!</p>
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
                @if($call_center->status == 4 && auth()->user()->can('view all users'))
                    <div class="modal fade" id="unBlockUser_{{$call_center->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-lg modal-danger" role="document">
                            <div class="modal-content">
                                <form action="{{ route('call-center.update-status', $call_center) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="2">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirm Un-block User?</h4>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to un-block the call center with name <strong>{{ $call_center->name}}</strong>.</p>

                                        <p>Please Check the agents you wish to unblock!</p>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sr. #</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>
                                                        <div class="d-flex align-items-center">Action <button class="btn btn-info btn-sm ml-auto" type="button" onclick="toggleAgentSelection();">Select/Deselect All</button></div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="agentsContainer">
                                                @foreach ($call_center->agents as $agent)
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td>{{ $agent->name }}</td>
                                                        <td>{{ $agent->email }}</td>
                                                        <td><input type="checkbox" class="form-control" style="max-width: 15px;" name="agents[]" value="{{ $agent->id }}" /></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
        </div>
    </div>
</x-dashboard-layout>
