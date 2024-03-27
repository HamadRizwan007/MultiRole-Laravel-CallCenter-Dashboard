<x-dashboard-layout>
    @if(auth()->user()->can('view all users'))
        <x-slot name="pageTitle">{{ucwords(request()->status ?? 'All')}} Managers</x-slot>
    @else
        @if(auth()->user()->hasRole("client broker"))
            <x-slot name="pageTitle">{{ucwords(request()->status ?? 'All')}} Client Managers</x-slot>
        @else
            <x-slot name="pageTitle">{{ucwords(request()->status ?? 'All')}} Managers</x-slot>
        @endif
    @endif

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client-manager.index') }}">Managers</a></li>
        @if(auth()->user()->can('view all users'))
            <li class="breadcrumb-item active">{{ucwords(request()->status ?? 'All')}}</li>
        @else
            @if(auth()->user()->hasRole("client broker"))
                <li class="breadcrumb-item active">{{ucwords(request()->status ?? 'All')}} Client Managers</li>
            @else
                <li class="breadcrumb-item active">{{ucwords(request()->status ?? 'All')}}</li>
            @endif
        @endif
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allManagers').DataTable();

                @foreach ($managers as $manager)
                    @if(in_array($manager->status, [1,2]))
                        @if($manager->client)
                            new SlimSelect({select: "#updateClientSelect_{{ $manager->id }}"});
                        @else
                            new SlimSelect({select: "#attachClientSelect_{{ $manager->id }}"});
                        @endif
                    @endif
                @endforeach
            });
        </script>
    </x-slot>

    <div>
        <div class="card">
            <div class="card-body">
                <table id="allManagers" class="table table-striped table-responsive-lg" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Name</th>
                            @if(auth()->user()->can('view all users') || auth()->user()->hasRole('client broker'))
                                <th>Client</th>
                            @endif
                            <th>Phone</th>
                            <th>Registered by</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($managers as $manager)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    {{ $manager->name }}
                                    <div class="text-muted">{{ $manager->email }}</div>
                                </td>
                                @if(auth()->user()->can('view all users') || auth()->user()->hasRole('client broker'))
                                    <td>
                                        @if($manager->client)
                                            {{ ucfirst($manager->client->name) }}
                                        @else
                                            @if($manager->client_id)
                                                Deleted
                                            @else
                                                NA
                                            @endif
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $manager->phone ?? 'NA' }}</td>
                                <td>
                                    @if($manager->created_by)
                                        {{ $manager->created_by->name }}
                                    @else
                                        @if($manager->created_by_id)
                                            Deleted
                                        @else
                                            Self Register
                                        @endif
                                    @endif
                                </td>
                                <td style="font-size: 1rem;" data-order="{{ $manager->status }}">
                                    @php
                                        $class_name = 'badge-info';
                                        switch ($manager->status) {
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
                                    <span class="badge {{ $class_name }}">{{ ucfirst($manager->status_text) }}</span>
                                </td>
                                @if ($manager->last_login_time)
                                    <td data-order="{{ $manager->last_login_time->setTimezone(auth()->user()->timezone)->getTimestamp() }}">
                                        {{ $manager->last_login_time->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}
                                    </td>
                                @else
                                    <td data-order="{{ now()->addDay()->getTimestamp() }}">
                                        NA
                                    </td>
                                @endif
                                <td>
                                    <div class="btn-group" role="group" aria-label="User actions">
                                        <a class="btn btn-info" href="{{ route('client-manager.show', $manager) }}">Profile</a>
                                        @if(auth()->user()->can('update client manager info') && $manager->status == 2)
                                            <a class="btn btn-warning" href="{{ route('client-manager.edit', $manager) }}">Edit</a>
                                        @endif
                                        @if(($manager->status == 1 || $manager->status == 2) && (auth()->user()->can('view all users') || auth()->user()->hasRole('client broker')))
                                            @if($manager->client)
                                                <button class="btn btn-primary" type="button"  data-toggle="modal" data-target="#updateClient_{{$manager->id}}">Update Client</button>
                                            @else
                                                <button class="btn btn-primary" type="button"  data-toggle="modal" data-target="#attachClient_{{$manager->id}}">Attach Client</button>
                                            @endif
                                        @endif
                                        @if($manager->status == 2 && auth()->user()->can('view all users'))
                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#blockUser_{{$manager->id}}">Block</button>
                                        @endif
                                        @if($manager->status == 3 && auth()->user()->can('view all users'))
                                            <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#activateUser_{{$manager->id}}">Activate</button>
                                        @endif
                                        @if($manager->status == 4 && auth()->user()->can('view all users'))
                                            <button class="btn btn-warning" type="button"  data-toggle="modal" data-target="#unBlockUser_{{$manager->id}}">Un-block</button>
                                        @endif
                                    </div>
                                    @if($manager->status == 1 && auth()->user()->can('view all users'))
                                    <div>
                                        <div class="mt-2 btn-group" role="group" aria-label="Approve or reject manager">
                                            <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#activateUser_{{$manager->id}}">Approve</button>
                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#rejectUser_{{$manager->id}}">Reject</button>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @if(($manager->status == 1 || $manager->status == 3) && auth()->user()->can('view all users'))
                                <div class="modal fade" id="activateUser_{{$manager->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-danger" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('client-manager.update-status', $manager) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="2">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Are you sure?</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to approve the profile for the manager with name <strong>{{ $manager->name}}</strong>.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                    @if($manager->status == 1)
                                                        <button class="btn btn-danger" type="submit">Approve</button>
                                                    @endif
                                                    @if($manager->status == 3)
                                                        <button class="btn btn-danger" type="submit">Activate</button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($manager->status == 1 && auth()->user()->can('view all users'))
                                <div class="modal fade" id="rejectUser_{{$manager->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-danger" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('client-manager.update-status', $manager) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="4">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirm reject manager?</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to reject the manager with name <strong>{{ $manager->name}}</strong>.</p>
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
                            @if($manager->status == 2 && auth()->user()->can('view all users'))
                                <div class="modal fade" id="blockUser_{{$manager->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-danger" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('client-manager.update-status', $manager) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="4">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirm Block User?</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to block the with name <strong>{{ $manager->name}}</strong>.</p>
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
                            @if($manager->status == 4 && auth()->user()->can('view all users'))
                                <div class="modal fade" id="unBlockUser_{{$manager->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-danger" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('client-manager.update-status', $manager) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="2">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirm Un-block User?</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to un-block the manager with name <strong>{{ $manager->name}}</strong>.</p>
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
                            @if(($manager->status == 1 || $manager->status == 2) && (auth()->user()->can('view all users') || auth()->user()->hasRole('client broker')))
                                @if($manager->client)
                                    <div class="modal fade" id="updateClient_{{$manager->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                        <div class="modal-dialog modal-primary" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('client-manager.update-client', $manager) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="2">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Update the manager's client</h4>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="client" style="font-size: 1.1em; margin-bottom: .5rem; display: block;">Attach Client</label>
                                                            <select name="client" id="updateClientSelect_{{ $manager->id }}" required>
                                                                <option value="">Select a new client for the manager</option>
                                                                @foreach ($clients->where('id', '!=', $manager->client->id) as $client)
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
                                    <div class="modal fade" id="attachClient_{{$manager->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                        <div class="modal-dialog modal-primary" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('client-manager.update-client', $manager) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="2">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Attach Client to manager</h4>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="client" style="font-size: 1.1em; margin-bottom: .5rem; display: block;">Client</label>
                                                            <select name="client" id="attachClientSelect_{{ $manager->id }}">
                                                                <option value="">Select a client for manager</option>
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
