<x-dashboard-layout>

    <x-slot name="pageTitle">{{ucwords(request()->status ?? 'All')}} Clients</x-slot>



    <x-slot name="breadcrumb">

        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>

        <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clients</a></li>

        <li class="breadcrumb-item active">{{ucwords(request()->status ?? 'All')}}</li>

    </x-slot>



    <x-slot name="scripts">

        <script>

            $(document).ready(function () {

                $('#allClients').DataTable();

            });



            const toggleAgentSelection = (container) => {

                const all_inputs = document.querySelectorAll(`#${container} input[type="checkbox"]`);

                const checked_inputs = document.querySelectorAll(`#${container} input[type="checkbox"]:checked`);



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

                <table id="allClients" class="table table-striped table-responsive-lg" style="width:100%">

                    <thead>

                        <tr>

                            <th>Sr #</th>

                            <th>ID</th>

                            <th style="width:100px;">Name/Email</th>

                            <th>Lead Type</th>

                            <th>External API</th>

                            <th>Lead Accept Status</th>

                            <th>Status</th>

                            <th>Last Login</th>

                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($clients as $client)

                            <tr>

                                <td>{{ $clients->firstItem()+$loop->index }}</td>

                                <td>{{ $client->uid }}</td>

                                <td>{{ $client->name }}<br>{{ $client->email }}</td>

                                <td>{{ ucwords($client->lead_type_text ?? 'NA') }}</td>

                                <td>

                                    @if ($client->api_url)

                                        Yes

                                    @else

                                        No

                                    @endif

                                </td>

                                <td style="font-size: 1rem;" data-order="{{ $client->currently_accepting_leads ? 1:2 }}">

                                    @if($client->currently_accepting_leads)

                                        <span class="badge badge-success text-white">Active</span>

                                    @else

                                        <span class="badge badge-danger text-white">Paused</span>

                                    @endif

                                </td>

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

                                        {!! $client->last_login_time->setTimezone(auth()->user()->timezone)->format('d M Y\<\b\r\> h:i A') !!}

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

                                        @if(auth()->user()->can('update client info') && $client->status == 2)

                                            <a class="btn btn-warning" href="{{ route('client.edit', $client) }}">Edit</a>

                                        @endif

                                        @if($client->status == 2 && auth()->user()->can('view all users'))

                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#blockUser_{{$client->id}}">Block</button>

                                        @endif

                                        @if($client->status == 3 && auth()->user()->can('view all users'))

                                            <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#activateUser_{{$client->id}}">Activate</button>

                                        @endif

                                        @if($client->status == 4 && auth()->user()->can('view all users'))

                                            <button class="btn btn-warning" type="button"  data-toggle="modal" data-target="#unBlockUser_{{$client->id}}">Un-block</button>

                                        @endif

                                    </div>

                                    @if($client->status == 1 && auth()->user()->can('view all users'))

                                    <div>

                                        <div class="mt-2 btn-group" role="group" aria-label="Approve or reject client">

                                            <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#activateUser_{{$client->id}}">Approve</button>

                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#rejectUser_{{$client->id}}">Reject</button>

                                        </div>

                                    </div>

                                    @endif

                                </td>

                            </tr>



                        @endforeach

                    </tbody>
                </table>
                {{ $clients->links() }}

            </div>

        </div>

    </div>

    @foreach ($clients as $client)

        @if(($client->status == 1 || $client->status == 3) && auth()->user()->can('view all users'))

            <div class="modal fade" id="activateUser_{{$client->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">

                <div class="modal-dialog modal-danger" role="document">

                    <div class="modal-content">

                        <form action="{{ route('client.update-status', $client) }}" method="POST">

                            @csrf

                            @method('PATCH')

                            <input type="hidden" name="status" value="2">

                            <div class="modal-header">

                                <h4 class="modal-title">Are you sure?</h4>

                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                            </div>

                            <div class="modal-body">

                                <p>Are you sure you want to approve the profile for the client with name <strong>{{ $client->name}}</strong>.</p>

                            </div>

                            <div class="modal-footer">

                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                                @if($client->status == 1)

                                    <button class="btn btn-danger" type="submit">Approve</button>

                                @endif

                                @if($client->status == 3)

                                    <button class="btn btn-danger" type="submit">Activate</button>

                                @endif

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        @endif

        @if($client->status == 1 && auth()->user()->can('view all users'))

            <div class="modal fade" id="rejectUser_{{$client->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">

                <div class="modal-dialog modal-danger" role="document">

                    <div class="modal-content">

                        <form action="{{ route('client.update-status', $client) }}" method="POST">

                            @csrf

                            @method('PATCH')

                            <input type="hidden" name="status" value="4">

                            <div class="modal-header">

                                <h4 class="modal-title">Confirm reject client?</h4>

                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                            </div>

                            <div class="modal-body">

                                <p>Are you sure you want to reject the client with name <strong>{{ $client->name}}</strong>.</p>

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

        @if($client->status == 2 && auth()->user()->can('view all users'))

            <div class="modal fade" id="blockUser_{{$client->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">

                <div class="modal-dialog modal-danger" role="document">

                    <div class="modal-content">

                        <form action="{{ route('client.update-status', $client) }}" method="POST">

                            @csrf

                            @method('PATCH')

                            <input type="hidden" name="status" value="4">

                            <div class="modal-header">

                                <h4 class="modal-title">Confirm Block User?</h4>

                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                            </div>

                            <div class="modal-body">

                                <p>Are you sure you want to block the with name <strong>{{ $client->name}}</strong>.</p>

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

        @if($client->status == 4 && auth()->user()->can('view all users'))

            <div class="modal fade" id="unBlockUser_{{$client->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">

                <div class="modal-dialog modal-lg modal-danger" role="document">

                    <div class="modal-content">

                        <form action="{{ route('client.update-status', $client) }}" method="POST">

                            @csrf

                            @method('PATCH')

                            <input type="hidden" name="status" value="2">

                            <div class="modal-header">

                                <h4 class="modal-title">Confirm Un-block User?</h4>

                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                            </div>

                            <div class="modal-body">

                                <p>Are you sure you want to un-block the client with name <strong>{{ $client->name}}</strong>.</p>



                                <p>Please Check the managers you wish to unblock!</p>

                                <table class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sr. #</th>

                                            <th>Name</th>

                                            <th>Email</th>

                                            <th>

                                                <div class="d-flex align-items-center">Action <button class="btn btn-info btn-sm ml-auto" type="button" onclick="toggleAgentSelection('managersContainer');">Select/Deselect All</button></div>

                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody id="managersContainer">

                                        @foreach ($client->client_managers as $manager)

                                            <tr>

                                                <td>{{ $loop->index + 1 }}</td>

                                                <td>{{ $manager->name }}</td>

                                                <td>{{ $manager->email }}</td>

                                                <td><input type="checkbox" class="form-control" style="max-width: 15px;" name="managers[]" value="{{ $manager->id }}" /></td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>



                                <p>Please Check the agents you wish to unblock!</p>

                                <table class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sr. #</th>

                                            <th>Name</th>

                                            <th>Email</th>

                                            <th>

                                                <div class="d-flex align-items-center">Action <button class="btn btn-info btn-sm ml-auto" type="button" onclick="toggleAgentSelection('agentsContainer');">Select/Deselect All</button></div>

                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody id="agentsContainer">

                                        @foreach ($client->client_agents as $agent)

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

</x-dashboard-layout>

