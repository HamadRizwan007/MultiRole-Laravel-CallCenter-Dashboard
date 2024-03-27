<x-dashboard-layout>
    <x-slot name="pageTitle">Client Broker Profile</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client-broker.index') }}">Client Brokers</a></li>
        <li class="breadcrumb-item active">Show</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allClients').DataTable();

                new SlimSelect({
                    select: '#client',
                    placeholder: 'Select client',
                });
            });
        </script>
    </x-slot>

    <div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <div class="w-25">
                            <img class="c-avatar-img" src="{{ $client_broker->avatar_url }}" alt="{{ ucfirst($client_broker->name) }}">
                        </div>
                        <h1 class="mt-2">{{ $client_broker->name }}</h1>
                        <p class="mt-1 mb-0"><strong>Database ID: </strong>{{ $client_broker->id }}</p>
                        <p class="mt-1 mb-0"><strong>Unique ID: </strong>{{ $client_broker->uid }}</p>
                        <p><strong>Email: </strong><a href="mailto:{{ $client_broker->email }}">{{ $client_broker->email }}</a></p>
                        <div>
                            <a class="btn btn-info" href="{{ route('client-broker.edit', $client_broker) }}">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <table class="table table-striped table-responsive-md">
                            <tr>
                                <th>First Name</th>
                                <td>{{ $client_broker->fname }}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>{{ $client_broker->lname }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $client_broker->username ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Agency</th>
                                <td>{{ $client_broker->agency ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $client_broker->phone ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Registered At</th>
                                <td>{{ $client_broker->created_at->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if (auth()->user()->hasAnyRole(['admin', 'client broker']) && $client_broker->lead_instructions)
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="h2">Lead Instructions</h4>
                        </div>
                        <div class="card-body">
                            {!! str_replace(["\n", "\n\r", "\xA0", "&#160;"], "<br>", $client_broker->lead_instructions) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h2 class="h3">Clients</h2>
                        <div>
                            <button class="btn btn-success" data-toggle="modal" data-target="#attachClientToBroker">Attach Client</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="allClients" class="table table-striped table-responsive-lg" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>State</th>
                                    <th>Name</th>
                                    <th style="width:100px;">Email</th>
                                    <th>Lead Type</th>
                                    <th>Has External API</th>
                                    @if(auth()->user()->hasRole('admin'))<th>Registered by</th>@endif
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client_broker->clients as $client)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $client->lead_state_names ?? '-' }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ ucwords($client->lead_type_text ?? 'NA') }}</td>
                                        <td>
                                            @if ($client->api_url)
                                                Yes
                                            @else
                                                No
                                            @endif
                                        </td>
                                        @if(auth()->user()->hasRole('admin'))
                                        <td>
                                            @if($client->created_by)
                                                {{ $client->created_by->name }}
                                            @else
                                                @if($client->created_by_id)
                                                    Deleted
                                                @else
                                                    Self Register
                                                @endif
                                            @endif
                                        </td>
                                        @endif
                                        <td style="font-size: 1rem;" data-order="{{ $client->status }}">
                                            @php
                                                $class_name = 'badge-info';
                                                switch ($client->status) {
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
                                            <span class="badge {{ $class_name }}">{{ ucfirst($client->status_text) }}</span>
                                        </td>
                                        @if ($client->last_login_time)
                                            <td data-order="{{ $client->last_login_time->setTimezone(auth()->user()->timezone)->getTimestamp() }}">
                                                {{ $client->last_login_time->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}
                                            </td>
                                        @else
                                            <td data-order="{{ now()->addDay()->getTimestamp() }}">
                                                NA
                                            </td>
                                        @endif
                                        <td>
                                            <div class="btn-group" role="group" aria-label="User actions">
                                                <a class="btn btn-info" href="{{ route('client.show', $client) }}">Profile</a>
                                                @if(auth()->user()->hasRole('admin'))
                                                    <a class="btn btn-primary" href="{{ route('client.leads', $client) }}">View Leads</a>
                                                @endif
                                                <button class="btn btn-danger" data-toggle="modal" data-target="#removeClientFromBroker_{{ $client->id }}">Remove From Broker</button>
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
        <div class="modal fade" id="attachClientToBroker" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-success" role="document">
                <div class="modal-content">
                    <form action="{{ route('client-broker.attach-client', $client_broker) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="2">
                        <div class="modal-header">
                            <h4 class="modal-title">Attach Client?</h4>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="api_type">Select Client</label>
                                <select name="client" id="client">
                                    <option value="">Select new client to attach to broker</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }} - {{ $client->uid }}</option>
                                    @endforeach
                                </select>
                                @error('client')
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

        @foreach ($client_broker->clients as $client)
            <div class="modal fade" id="removeClientFromBroker_{{ $client->id }}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <form action="{{ route('client-broker.remove-client', $client) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="2">
                            <div class="modal-header">
                                <h4 class="modal-title">Confirm remove client from broker?</h4>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    Are you sure you wish to remove the client with name [{{ $client->name }}] form this broker?
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
        @endforeach
    </div>
</x-dashboard-layout>
