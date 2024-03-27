<x-dashboard-layout>
    <x-slot name="pageTitle">Client Profile</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clients</a></li>
        <li class="breadcrumb-item active">Show</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            const days = @json(array_keys(\App\Models\ClientTimetable::$weekdays));
            const toggleStartEndTimes = (day) => {
                const dayTimingOptionValue = document.getElementById(`${day}Timing`).value;
                const dayLeadCount = document.getElementById(`${day}LeadCount`);
                const timeSetContainer = document.getElementById(`${day}TimeSetsContainer`);
                const timeInputs = document.querySelectorAll(`#${day}TimeSetsContainer [type="time"]`);
                const timeSetAdder = document.getElementById(`${day}TimeSetAdder`);

                if(dayTimingOptionValue == 2){
                    dayLeadCount.setAttribute('disabled', true);
                } else {
                    dayLeadCount.removeAttribute('disabled');
                }

                if(dayTimingOptionValue != 3){
                    timeSetAdder.style.display = 'none';
                    if(timeInputs){
                        timeInputs.forEach(input => {
                            input.setAttribute('disabled', true);
                            input.value = "";
                        })
                    }
                } else {
                    timeSetAdder.style.display = 'inline-block';
                    if(timeInputs){
                        timeInputs.forEach(input => {
                            input.removeAttribute('disabled');
                        })
                    }
                }
            }

            const getTimeSetHTML = (day, num) => {
                return `<div class="d-flex justify-content-stretch align-items-end mb-2" data-id="${num}">
                            <div class="form-group mb-0 mr-2" style="width: 40%">
                                <label>Start</label>
                                <input type="time" class="form-control" name="${day}_time_sets[${num}][start]">
                            </div>
                            <div class="form-group mb-0 mr-2" style="width: 40%">
                                <label>End</label>
                                <input type="time" class="form-control" name="${day}_time_sets[${num}][end]">
                            </div>
                            <button class="btn btn-danger" type="button" onclick="removeTimeSet(event, '${day}')">Remove</button>
                        </div>`;
            }

            const addTimeSet = (day) => {
                const timeSetContainer = document.getElementById(`${day}TimeSetsContainer`);
                let inputNumber = timeSetContainer.children[timeSetContainer.children.length - 1];
                inputNumber = Number(inputNumber.getAttribute('data-id')) + 1;

                const htmlString = getTimeSetHTML(day, inputNumber);

                timeSetContainer.insertAdjacentHTML("beforeend", htmlString);
            }

            const removeTimeSet = (e, day) => {
                if(document.getElementById(`${day}TimeSetsContainer`).children.length < 2){
                    document.getElementById(`${day}Timing`).value = 1;
                    document.getElementById(`${day}Timing`).onchange();
                    return;
                }
                e.currentTarget.parentNode.remove();
            }

            $(document).ready(function () {
                $('#allClientCampaigns').DataTable();

                days.forEach(day => toggleStartEndTimes(day.toLowerCase()));
            });
        </script>
    </x-slot>

    <div>
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mx-auto" role="alert" style="width: max-content; max-width: 740px;">
            <strong>Fix the following error before proceeding!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <div class="w-50">
                            <img class="c-avatar-img" src="{{ $client->avatar_url }}" alt="{{ ucfirst($client->name) }}">
                        </div>
                        <h1 class="mt-2">{{ $client->name }}</h1>
                        @role('admni')<p class="mt-1 mb-0"><strong>DB D: </strong>{{ $client->id }}</p>@endrole
                        <p class="mt-1 mb-0"><strong>Unique ID: </strong>{{ $client->uid }}</p>
                        <p class="mt-1 mb-0"><strong>State(s): </strong>{{ count($client->lead_states ?? []) }}</p>
                        <p class="mt-1 mb-0"><strong>Lead Accept Status: </strong>{{ $client->currently_accepting_leads ? "Active":"Paused" }}</p>
                        <p><strong>Email: </strong><a href="mailto:{{ $client->email }}">{{ $client->email }}</a></p>
                        <div>
                            <a class="btn btn-info" href="{{ route('client.edit', $client) }}">Edit Profile</a>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#updateLeadAcceptStatus">Update Lead Accept Status</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="updateLeadAcceptStatus" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <form action="{{ route('client.update-lead-accept-status', $client) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="modal-header">
                                <h4 class="modal-title">Update Lead Accept Status</h4>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="lead_accept_status">Select Client</label>
                                    <select name="lead_accept_status" id="lead_accept_status" class="form-control">
                                        <option value="">Select the manual lead accept status</option>
                                        @foreach (\App\Models\User::$leadAcceptStatuses as $key => $value)
                                            <option value="{{ $key }}" @if($client->lead_accept_status == $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('lead_accept_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <strong>Note: </strong> Lead Accept Status also changes based on client's timetable.<br>The above status optoin is client's manual pause status. This will only overwrite the timetable based status if it is set to paused.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <table class="table table-striped table-responsive-md">
                            <tr>
                                <th>First Name</th>
                                <td>{{ $client->fname }}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>{{ $client->lname }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $client->username ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Agency</th>
                                <td>{{ $client->agency ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $client->phone ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>DID Number</th>
                                <td>{{ $client->did_number ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Lead Type</th>
                                <td>{{ ucwords($client->lead_type_text ?? 'NA') }}</td>
                            </tr>
                            <tr>
                                <th>Lead Transfer Type</th>
                                <td>{{ $client->lead_request_type_text ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Daily Leads</th>
                                <td>{{ $client->lead_request_cap ?? 'Unlimited' }}</td>
                            </tr>
                            <tr>
                                <th>External API URL</th>
                                <td>{{ $client->api_url ?? 'Not set' }}</td>
                            </tr>
                            <tr>
                                <th>Registered At</th>
                                <td>{{ $client->created_at->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Assigned States</th>
                                <td>{{ $client->lead_state_names }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if (auth()->user()->hasAnyRole(['admin', 'client broker']))
            <div class="row justify-content-center">
                @if($client->lead_instructions)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="h2">Lead Instructions</h4>
                            </div>
                            <div class="card-body">
                                {!! str_replace(["\n", "\n\r", "\xA0", "&#160;"], "<br>", $client->lead_instructions) !!}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="mb-0">Timetable ({{ $client->timezone_text }})</h4>
                            @role('admin')
                            <div>
                                @if($client->client_timetable)
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateTimetableModal">Update Timetable</button>
                                @else
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#createTimetableModal">Create Timetable</button>
                                @endif
                            </div>
                            @endrole
                        </div>
                        <div class="card-body">
                            @if($client->client_timetable)
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr #</th>
                                        <th>Day</th>
                                        <th>Lead Count</th>
                                        <th>Timing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Models\ClientTimetable::$weekdays as $day => $number)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $day }}</td>
                                            <td>{{ $client->client_timetable->{Str::lower($day."_lead_count")} ?? 0 }}</td>
                                            <td>
                                                @if($client->client_timetable->{Str::lower($day."_timing")} != 3)
                                                    {{ \App\Models\ClientTimetable::$dayTimingOptions[$client->client_timetable->{Str::lower($day)."_timing"}] }}
                                                @else
                                                    <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                        @foreach ($client->client_timetable->{Str::lower($day)."_time_sets"} as $set)
                                                            <div class="mr-2">
                                                                <strong>Start: </strong> {{ now()->setTimeFromTimeString($set['start'])->format('h:i A') }}<br>
                                                                <strong>End: </strong> {{ now()->setTimeFromTimeString($set['end'])->format('h:i A') }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                <p>No timetable set for the client!</p>
                                <p class="font-weight-bold">Leads can be transfered to the client at any time.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @role('admin')
            @if($client->client_timetable)
            <div class="modal fade" id="updateTimetableModal" tabindex="-1" role="dialog" aria-labelledby="updateTimetableModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateTimetableModalLabel">Update Timetable ({{ $client->timezone_text }})</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('client.timetable.update', ['client' => $client, 'timetable' => $client->client_timetable])}}" method="POST" enctype="multiple/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="modal-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>Sr. #</th>
                                        <th>Day</th>
                                        <th>Lead Count</th>
                                        <th>Timing Type</th>
                                        <th>Time Sets</th>
                                    </thead>
                                    <tbody>
                                        @foreach (\App\Models\ClientTimetable::$weekdays as $day => $number)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $day }}</td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                            name="{{ Str::lower($day) }}_lead_count"
                                                            id="{{ Str::lower($day) }}LeadCount"
                                                            value="{{ old(Str::lower($day)."_lead_count", $client->client_timetable->{Str::lower($day)."_lead_count"}) }}"
                                                            placeholder="Enter lead acceptance count"
                                                    >
                                                </td>
                                                <td>
                                                    <select class="form-control" name="{{ Str::lower($day) }}_timing" id="{{ Str::lower($day) }}Timing" onchange="toggleStartEndTimes('{{ Str::lower($day) }}')" required>
                                                        <option value="">Select Timing</option>
                                                        @foreach (\App\Models\ClientTimetable::$dayTimingOptions as $key => $value)
                                                            <option value="{{ $key }}" @if(old(Str::lower($day)."_timing", $client->client_timetable->{Str::lower($day)."_timing"}) == $key) selected @endif>{{ ucwords($value) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button class="btn btn-success my-2" type="button" id="{{ Str::lower($day) }}TimeSetAdder" onclick="addTimeSet('{{ Str::lower($day) }}')">+ Add Time Set</button>
                                                </td>
                                                <td id="{{ Str::lower($day) }}TimeSetsContainer">
                                                    @foreach (old(Str::lower($day)."_time_sets", $client->client_timetable->{Str::lower($day)."_time_sets"} ?? [['start' => '', 'end' => '']]) as $key => $set)
                                                        <div class="d-flex justify-content-stretch align-items-end mb-2" data-id="{{ $key }}">
                                                            <div class="form-group mb-0 mr-2" style="width: 40%">
                                                                <label>Start</label>
                                                                <input type="time" class="form-control" name="{{ Str::lower($day) }}_time_sets[{{ $key }}][start]" value="{{ $set['start'] }}">
                                                            </div>
                                                            <div class="form-group mb-0 mr-2" style="width: 40%">
                                                                <label>End</label>
                                                                <input type="time" class="form-control" name="{{ Str::lower($day) }}_time_sets[{{ $key }}][end]" value="{{ $set['end'] }}">
                                                            </div>
                                                            <button class="btn btn-danger" type="button" onclick="removeTimeSet(event, '{{ Str::lower($day) }}')">Remove</button>
                                                        </div>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Update Timetable</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @else
                <div class="modal fade" id="createTimetableModal" tabindex="-1" role="dialog" aria-labelledby="createTimetableModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createTimetableModalLabel">Create Timetable ({{ $client->timezone_text }})</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('client.timetable.store', $client)}}" method="POST" enctype="multiple/form-data">
                                @csrf
                                <div class="modal-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <th>Sr. #</th>
                                            <th>Day</th>
                                            <th>Lead Count</th>
                                            <th>Timing Type</th>
                                            <th>Time Sets</th>
                                        </thead>
                                        <tbody>
                                            @foreach (\App\Models\ClientTimetable::$weekdays as $day => $number)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $day }}</td>
                                                    <td>
                                                        <input type="number" class="form-control"
                                                                name="{{ Str::lower($day) }}_lead_count"
                                                                id="{{ Str::lower($day) }}LeadCount"
                                                                value="{{ old(Str::lower($day)."_lead_count") }}"
                                                                placeholder="Enter lead acceptance count"
                                                        >
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="{{ Str::lower($day) }}_timing" id="{{ Str::lower($day) }}Timing" onchange="toggleStartEndTimes('{{ Str::lower($day) }}')" required>
                                                            <option value="">Select Timing</option>
                                                            @foreach (\App\Models\ClientTimetable::$dayTimingOptions as $key => $value)
                                                                <option value="{{ $key }}" @if(old(Str::lower($day)."_timing") == $key) selected @endif>{{ ucwords($value) }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button class="btn btn-success my-2" type="button" id="{{ Str::lower($day) }}TimeSetAdder" onclick="addTimeSet('{{ Str::lower($day) }}')">+ Add Time Set</button>
                                                    </td>
                                                    <td id="{{ Str::lower($day) }}TimeSetsContainer">
                                                        @foreach (old(Str::lower($day)."_time_sets", [['start' => '', 'end' => '']]) as $key => $set)
                                                            <div class="d-flex justify-content-stretch align-items-end mb-2" data-id="{{ $key }}">
                                                                <div class="form-group mb-0 mr-2" style="width: 40%">
                                                                    <label>Start</label>
                                                                    <input type="time" class="form-control" name="{{ Str::lower($day) }}_time_sets[{{ $key }}][start]" value="{{ $set['start'] }}">
                                                                </div>
                                                                <div class="form-group mb-0 mr-2" style="width: 40%">
                                                                    <label>End</label>
                                                                    <input type="time" class="form-control" name="{{ Str::lower($day) }}_time_sets[{{ $key }}][end]" value="{{ $set['end'] }}">
                                                                </div>
                                                                <button class="btn btn-danger" type="button" onclick="removeTimeSet(event, '{{ Str::lower($day) }}')">Remove</button>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Create Timetable</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endrole
        @role('admin')
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="h4">Client Campaigns</h3>
                        <a href="{{ route('client.campaign.create', $client) }}" class="btn btn-success">Create New</a>
                    </div>
                    <div class="card-body">
                        <table id="allClientCampaigns" class="table table-striped table-responsive-lg" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>State</th>
                                    <th>Lead Types</th>
                                    <th>Quote Type</th>
                                    <th>DID Number</th>
                                    <th>Daily Leads</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->campaigns as $campaign)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            @if($campaign->states->pluck('name')->count() < 4)
                                                {{ $campaign->states->pluck('name')->join(', ') }}
                                            @else
                                                {{ $campaign->states->count() }} states
                                            @endif
                                        </td>
                                        <td>{{ $campaign->lead_types_texts }}</td>
                                        <td>{{ $campaign->lead_request_types_texts }}</td>
                                        <td>{{ $campaign->did_number }}</td>
                                        <td>{{ $campaign->daily_leads }}</td>
                                        <td>
                                            <div>
                                                <strong>Admin: </strong> ${{ $campaign->admin_price }}
                                            </div>
                                            <div>
                                                <strong>Call Center: </strong> ${{ $campaign->center_price }}
                                            </div>
                                        </td>
                                        <td style="font-size: 1rem;" data-order="{{ $campaign->status }}">
                                            @php
                                                $class_name = 'badge-info';
                                                switch ($campaign->status) {
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
                                                        $class_name = 'badge-info';
                                                        break;
                                                }
                                            @endphp
                                            <span class="badge {{ $class_name }}">{{ ucfirst($campaign->status_text) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('client.campaign.edit', ['client' => $client, 'campaign' => $campaign]) }}" class="btn btn-warning">Edit</a>
                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#deleteModal_{{$campaign->id}}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @foreach ($client->campaigns as $campaign)
                            <div class="modal fade" id="deleteModal_{{$campaign->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog modal-danger" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('client.campaign.destroy', ['client' => $client, 'campaign' => $campaign]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirm delete client campaign?</h4>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete the campaign for client <strong>{{ $client->name}}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endrole
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3 class="h4 mb-0">Client Managers</h3></div>
                    <div class="card-body">
                        <table id="allAgents" class="table table-striped table-responsive-lg" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    @if(auth()->user()->hasRole('admin'))<th>Registered by</th>@endif
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->client_managers as $agent)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $agent->name }}<br>{{ $agent->email }}</td>
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
                                                <a class="btn btn-info" href="{{ route('client-manager.show', $agent) }}">Profile</a>
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
            </div><div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3 class="h4 mb-0">Client Agents</h3></div>
                    <div class="card-body">
                        <table id="allAgents" class="table table-striped table-responsive-lg" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    @if(auth()->user()->hasRole('admin'))<th>Registered by</th>@endif
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->client_agents as $agent)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $agent->name }}<br>{{ $agent->email }}</td>
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
                                                <a class="btn btn-info" href="{{ route('client-manager.show', $agent) }}">Profile</a>
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
    </div>
    @foreach ($client->client_agents->merge($client->client_managers) as $agent)
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
