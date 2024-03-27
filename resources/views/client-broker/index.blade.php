<x-dashboard-layout>
    <x-slot name="pageTitle">{{ucwords(request()->status ?? 'All')}} Client Brokers</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client-broker.index') }}">Client Brokers</a></li>
        <li class="breadcrumb-item active">{{ucwords(request()->status ?? 'All')}}</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allClientBroker').DataTable();
            });
        </script>
    </x-slot>

    <div>
        <div class="card">
            <div class="card-body">
                <table id="allClientBroker" class="table table-striped table-responsive-lg" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th style="width:100px;">Email</th>
                            <th>Attached Clients</th>
                            <th>Registered by</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($client_brokers as $client_broker)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $client_broker->uid }}</td>
                                <td>{{ $client_broker->name }}</td>
                                <td>{{ $client_broker->email }}</td>
                                <td>{{ $client_broker->clients_count }}</td>
                                <td>
                                    @if($client_broker->created_by)
                                        {{ $client_broker->created_by->name }}
                                    @else
                                        @if($client_broker->created_by_id)
                                            Deleted
                                        @else
                                            Self Register
                                        @endif
                                    @endif
                                </td>
                                <td style="font-size: 1rem;" data-order="{{ $client_broker->status }}">
                                    @php
                                        $class_name = 'badge-info';
                                        switch ($client_broker->status) {
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
                                    <span class="badge {{ $class_name }}">{{ ucfirst($client_broker->status_text) }}</span>
                                </td>
                                @if ($client_broker->last_login_time)
                                    <td data-order="{{ $client_broker->last_login_time->setTimezone(auth()->user()->timezone)->getTimestamp() }}">
                                        {{ $client_broker->last_login_time->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}
                                    </td>
                                @else
                                    <td data-order="{{ now()->addDay()->getTimestamp() }}">
                                        NA
                                    </td>
                                @endif
                                <td>
                                    <div class="btn-group" role="group" aria-label="User actions">
                                        <a class="btn btn-info" href="{{ route('client-broker.show', $client_broker) }}">Profile</a>
                                        @if(auth()->user()->can('update client broker info') && $client_broker->status == 2)
                                            <a class="btn btn-warning" href="{{ route('client-broker.edit', $client_broker) }}">Edit</a>
                                        @endif
                                        @if($client_broker->status == 2 && auth()->user()->can('view all users'))
                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#blockUser_{{$client_broker->id}}">Block</button>
                                        @endif
                                        @if($client_broker->status == 3 && auth()->user()->can('view all users'))
                                            <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#activateUser_{{$client_broker->id}}">Activate</button>
                                        @endif
                                        @if($client_broker->status == 4 && auth()->user()->can('view all users'))
                                            <button class="btn btn-warning" type="button"  data-toggle="modal" data-target="#unBlockUser_{{$client_broker->id}}">Un-block</button>
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

    @foreach ($client_brokers as $client_broker)
    @if(($client_broker->status == 1 || $client_broker->status == 3) && auth()->user()->can('view all users'))
        <div class="modal fade" id="activateUser_{{$client_broker->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form action="{{ route('client-broker.update-status', $client_broker) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="2">
                        <div class="modal-header">
                            <h4 class="modal-title">Are you sure?</h4>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to approve the profile for the client broker with name <strong>{{ $client_broker->name}}</strong>.</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                            @if($client_broker->status == 1)
                                <button class="btn btn-danger" type="submit">Approve</button>
                            @endif
                            @if($client_broker->status == 3)
                                <button class="btn btn-danger" type="submit">Activate</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @if($client_broker->status == 1 && auth()->user()->can('view all users'))
        <div class="modal fade" id="rejectUser_{{$client_broker->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form action="{{ route('client-broker.update-status', $client_broker) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="4">
                        <div class="modal-header">
                            <h4 class="modal-title">Confirm reject client?</h4>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to reject the client broker with name <strong>{{ $client_broker->name}}</strong>.</p>
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
    @if($client_broker->status == 2 && auth()->user()->can('view all users'))
        <div class="modal fade" id="blockUser_{{$client_broker->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form action="{{ route('client-broker.update-status', $client_broker) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="4">
                        <div class="modal-header">
                            <h4 class="modal-title">Confirm Block User?</h4>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to block the client broker with name <strong>{{ $client_broker->name}}</strong>.</p>
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
    @if($client_broker->status == 4 && auth()->user()->can('view all users'))
        <div class="modal fade" id="unBlockUser_{{$client_broker->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form action="{{ route('client-broker.update-status', $client_broker) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="2">
                        <div class="modal-header">
                            <h4 class="modal-title">Confirm Un-block User?</h4>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to un-block the client broker with name <strong>{{ $client_broker->name}}</strong>.</p>
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
