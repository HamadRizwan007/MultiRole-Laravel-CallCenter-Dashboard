<x-dashboard-layout>
    <x-slot name="pageTitle">Lead Details</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
        <li class="breadcrumb-item active">Show</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function(){
                new SlimSelect({select: "#selectLeadClient"});
            })
        </script>
    </x-slot>

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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Lead Details</h4>
                    @if(in_array(auth()->user()->id, $can_edit_ids))
                        <a class="btn btn-warning" href="{{ route('leads.edit', $lead) }}">Edit</a>
                    @endif
                    @if (auth()->user()->hasRole('client agent') && $lead->client && !$lead->client_agent)
                        <a href="{{ route('leads.attach-self-as-client_agent', $lead) }}" class="btn btn-info">Attach to lead as Agent</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped table-borderless table-responsive-lg w-100">
                                <tbody>
                                    <tr>
                                        <th class="w-25">Name</th>
                                        <td class="w-75">{{ ucfirst($lead->name) }}</a></td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">Date of Birth</th>
                                        <td class="w-75">{{ $lead->dob->format('d M Y') ?? 'NA' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">Phone</th>
                                        <td class="w-75"><a href="tel:{{ $lead->phone }}">{{ $lead->phone }}</a></td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">Quote Type</th>
                                        <td class="w-75">{{ ucwords($lead->quote_type) }}</td>
                                    </tr>
                                    @if($lead->insured_by)
                                    <tr>
                                        <th class="w-25">Insured By</th>
                                        <td class="w-75">{{ $lead->insured_by ?? "NA" }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th class="w-25">Call Time</th>
                                        <td class="w-75">{{ ucwords($lead->call_time_text) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">Transfer Type</th>
                                        <td class="w-75">
                                            @if($lead->assign_type)
                                                {{ ucwords($lead->assign_type_text) }}
                                            @else
                                                NA
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">Transferred At</th>
                                        <td class="w-75">
                                            @if($lead->assigned_time)
                                                {{ $lead->assigned_time->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}
                                            @else
                                                NA
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">Created At</th>
                                        <td class="w-75">{{ $lead->created_at->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}</td>
                                    </tr>
                                    @if($lead->client && auth()->user()->hasRole('admin'))
                                        <tr>
                                            <th class="w-25">Client has External API</th>
                                            <td class="w-75">
                                                @if($lead->client->api_url)
                                                    Yes
                                                @else
                                                    No
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="w-25">External ID</th>
                                            <td class="w-75">{{ $lead->external_id ?? 'NA' }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped table-borderless table-responsive-lg w-100">
                                <tbody>
                                    <tr>
                                        <th class="w-25">Address</th>
                                        <td class="w-75">{{ ucfirst($lead->full_address ?? 'NA')}}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25">Country</th>
                                        <td class="w-75">{{ ucwords($lead->country) ?? 'NA' }}</td>
                                    </tr>
                                    @if(in_array($lead->quote, [1, 3]) && $lead->owner_type)
                                    <tr>
                                        <th class="w-25">Ownership Type</th>
                                        <td class="w-75">{{ $lead->owner_type }}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [1, 3]) && $lead->home_type)
                                    <tr>
                                        <th class="w-25">Home Type</th>
                                        <td class="w-75">{{ $lead->home_type ?? 'NA' }}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [1,2,3,4,5]) && $lead->insurance_duration)
                                    <tr>
                                        <th class="w-25">Insurance Duration</th>
                                        <td class="w-75">
                                            {{ $lead->insurance_duration }} years
                                        </td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [4,5]) && $lead->quote_interested_in)
                                    <tr>
                                        <th class="w-25">Quote Interested In</th>
                                        <td class="w-75">{{ $lead->quote_interested_in_text ?? 'NA'}}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [4,5]) && $lead->have_active_checking_account)
                                    <tr>
                                        <th class="w-25">Active Checking Account</th>
                                        <td class="w-75">{{ $lead->have_active_checking_account_text ?? 'NA'}}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [4,5]) && $lead->can_pay_through)
                                    <tr>
                                        <th class="w-25">Payment Through</th>
                                        <td class="w-75">{{ $lead->can_pay_through_text ?? 'NA'}}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [1,3]) && $lead->home_built_after_2006)
                                    <tr>
                                        <th class="w-25">Home built in or after 2006</th>
                                        <td class="w-75">{{ $lead->home_built_after_2006 ?? 'NA'}}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [1,3]) && $lead->home_4_miles_away_from_water)
                                    <tr>
                                        <th class="w-25">Home 4KM away from any water source</th>
                                        <td class="w-75">{{ $lead->home_4_miles_away_from_water ?? 'NA'}}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [1,3]) && $lead->condo_built_after_2001)
                                    <tr>
                                        <th class="w-25">Condo/Apartment built in or after 2001</th>
                                        <td class="w-75">{{ $lead->condo_built_after_2001 ?? 'NA'}}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [2,3]) && $lead->cars_owned)
                                    <tr>
                                        <th class="w-25">Cars Owned</th>
                                        <td class="w-75">{{ $lead->cars_owned ?? 'NA' }}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [2,3]) && $lead->description)
                                    <tr>
                                        <th class="w-25" rowspan="3">Cars Description</th>
                                        <td class="w-75" rowspan="3">{{ $lead->description ?? 'NA' }}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [5]) && $lead->has_active_ssn)
                                    <tr>
                                        <th class="w-25">Active SSN</th>
                                        <td class="w-75">{{ ucfirst($lead->has_active_ssn) ?? 'NA' }}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [5]) && $lead->decision_maker)
                                    <tr>
                                        <th class="w-25">Decision Maker</th>
                                        <td class="w-75">{{ ucfirst($lead->decision_maker) ?? 'NA' }}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [5]) && $lead->monthly_payment_40_100)
                                    <tr>
                                        <th class="w-25">Monthly Payment 35$-75$</th>
                                        <td class="w-75">{{ ucfirst($lead->monthly_payment_40_100) ?? 'NA' }}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [5]) && $lead->fav_four_digits)
                                    <tr>
                                        <th class="w-25">You favorite 4 digits</th>
                                        <td class="w-75">{{ ucfirst($lead->fav_four_digits) ?? 'NA' }}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [5]) && $lead->move_forward_today)
                                    <tr>
                                        <th class="w-25">If we find an affordable option, are you willing to move forward today?</th>   
                                        <td class="w-75">{{ ucfirst($lead->move_forward_today) ?? 'NA' }}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [5]) && $lead->any_critical_illness)
                                    <tr>
                                        <th class="w-25">Any Critical Illness</th>
                                        <td class="w-75">{{ ucfirst($lead->any_critical_illness) ?? 'NA' }}</td>
                                    </tr>
                                    @endif
                                    @if(in_array($lead->quote, [5]) && $lead->critical_illness)
                                    <tr>
                                        <th class="w-25">Critical Illness</th>
                                        <td class="w-75">{{ ucfirst($lead->critical_illness) ?? 'NA' }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        @if(auth()->user()->hasAnyRole(['call center', 'admin']) && $lead->note)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Status Note</div>
                    <div class="card-body">{!! str_replace('\n', '<br>', $lead->note) !!}</div>
                </div>
            </div>
        @endif
        @if(auth()->user()->hasAnyRole(['call center', 'admin']) && $lead->delete_reason && $lead->deleted_by_id)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Delete Reason</div>
                    <div class="card-body">{!! ucfirst(str_replace('\n', '<br>', $lead->delete_reason)) !!}</div>
                </div>
            </div>
        @endif
        @if(auth()->user()->hasRole(['admin']) && $lead->payment_note)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Payment Status Note</div>
                    <div class="card-body">{!! str_replace('\n', '<br>', $lead->payment_note) !!}</div>
                </div>
            </div>
        @endif
    </div>
    <div class="row justify-content-center">
        @if(!auth()->user()->hasAnyRole('client', 'client agent', 'client manager', 'client broker'))
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Call Center</div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div class="w-50">
                        <img class="c-avatar-img" src="{{ $lead->call_center->avatar_url }}" alt="{{ ucfirst($lead->call_center->name) }}">
                    </div>
                    <h1 class="mt-2"><a href="{{ route('call-center.show', $lead->call_center) }}">{{ $lead->call_center->name }}</a></h1>
                    @if($lead->call_center->phone)
                        <p><strong>Phone: </strong><a href="tel:{{ $lead->call_center->phone }}">{{ $lead->call_center->phone }}</a></p>
                    @endif
                </div>
            </div>
        </div>
        @endif
        @if(!auth()->user()->hasRole(['client', 'client agent', 'client manager']))
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Client</div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    @if($lead->client)
                        @if(auth()->user()->hasAnyRole('admin', 'client broker'))
                            <div class="w-50">
                                <img class="c-avatar-img" src="{{ $lead->client->avatar_url }}" alt="{{ $lead->client->name }}">
                            </div>
                            <h1 class="mt-2"><a href="{{ route('client.show', $lead->client) }}">{{ $lead->client->name }}</a></h1>
                            <p><strong>Email: </strong><a href="mailto:{{ $lead->client->email }}">{{ $lead->client->email }}</a></p>
                            @role('admin')<a href="{{ route('leads.remove_client', $lead) }}" class="btn btn-danger btn-sm">Remove Client</a>@endrole
                        @else
                            The lead has been assigned to a client with id <strong>{{ $lead->client->uid }}</strong>.
                        @endif
                    @else
                        @if(auth()->user()->can('attach client to lead'))
                            <a class="btn btn-info text-white" type="button"  data-toggle="modal" data-target="#addClient_{{$lead->id}}">Attach Client</a>
                            <div class="modal fade" id="addClient_{{$lead->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog modal-info" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('leads.attach-client', $lead) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title">Attach Client to Lead</h4>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="client">Select Client</label>
                                                    <select name="client" id="selectLeadClient">
                                                        <option value="" selected>Select Client</option>
                                                        @foreach ($clients as $client)
                                                            <option value="{{ $client->id }}" @if(old('client') == $client->id) selected @endif>@if(auth()->user()->hasRole('admin')) {{ $client->id }} - {{ $client->name }} @else {{ $client->uid }} @endif</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="assign_type">Assign Type</label>
                                                    <select name="assign_type" class="form-control @error('assign_type') is-invalid @enderror">
                                                        <option value="" selected>Select lead assignment type</option>
                                                        @foreach (\App\Models\Lead::$assignTypes as $key => $type)
                                                            <option value="{{ $key }}" @if(old('assign_type') == $key) selected @endif>{{ ucwords($type) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                <button class="btn btn-info" type="submit">Confirm Attach</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        @endif
        @if (auth()->user()->hasAnyRole(['admin', 'client', 'client manager', 'client broker', 'call center', 'agent']) && $lead->client)
        {{-- <div class="col-md-4">
            <div class="card">
                <div class="card-header">Agent</div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    @if($lead->client_agent)
                        @if(auth()->user()->hasAnyRole(['admin', 'client', 'client_manger']))
                            <div class="w-50">
                                <img class="c-avatar-img" src="{{ $lead->client_agent->avatar_url }}" alt="{{ $lead->client_agent->name }}">
                            </div>
                            <h1 class="mt-2"><a href="{{ route('client.show', $lead->client) }}">{{ $lead->client_agent->name }}</a></h1>
                            <p><strong>email: </strong><a href="mailto:{{ $lead->client_agent->email }}">{{ $lead->client_agent->email }}</a></p>
                            <a href="{{ route('leads.remove_client_agent', $lead) }}" class="btn btn-danger btn-sm">Remove Client Agent</a>
                        @else
                            The lead has been assigned to a client agent with id <strong>{{ $lead->client_agent->id }}</strong>.
                        @endif
                    @else
                        @if(auth()->user()->hasRole('admin'))
                        <a class="btn btn-info text-white" type="button"  data-toggle="modal" data-target="#addClientAgent_{{$lead->id}}">Attach Client Agent</a>
                        <div class="modal fade" id="addClientAgent_{{$lead->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                            <div class="modal-dialog modal-info" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('leads.attach-client-agent', $lead) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h4 class="modal-title">Attach Client Agent to Lead</h4>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="client_agent">Select Client Agent</label>
                                                <select name="client_agent" id="selectLeadClient">
                                                    <option value="" selected>Select Client Agent</option>
                                                    @foreach ($client_agents as $client_agent)
                                                        <option value="{{ $client_agent->id }}" @if(old('client_agent') == $client_agent->id) selected @endif>{{ $client_agent->id }} - {{ $client_agent->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                            <button class="btn btn-info" type="submit">Confirm Attach</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @else
                            No Client Agent
                        @endif
                    @endif
                </div>
            </div>
        </div> --}}
        @endif
    </div>
</x-dashboard-layout>
