<x-dashboard-layout>
    <x-slot name="pageTitle">{{ $client->name }}'s' Leads</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('call-center.index') }}">Leads</a></li>
        @if (request()->routeIs('leads.all_leads'))
            <li class="breadcrumb-item active">All</li>
        @endif
        @if (request()->routeIs('leads.created_leads'))
            <li class="breadcrumb-item active">Created</li>
        @endif
        @if (request()->routeIs('leads.assigned_leads'))
            <li class="breadcrumb-item active">Assigned</li>
        @endif
        @if (auth()->user()->hasRole('client') ||
    auth()->user()->hasRole('client agent'))
            <li class="breadcrumb-item active">Index</li>
        @endif
    </x-slot>

    <x-slot name="styles">
        <style>
            div.dt-button-collection {
                padding: 0;
                border-radius: 10px;
            }
            div.dt-button-collection .active {
                background-color: #39f;
            }
            div.dt-button-collection .active:hover {
                background-color: #0080ff;
            }
        </style>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $('#allLeads').DataTable({
                    dom:    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                            "<'row'<'col-sm-12'B>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        'colvis',
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                            }
                        },
                    ]
                });
            })
        </script>
    </x-slot>

    <div>
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="text-value-lg">{{ $leads->count() }}</div>
                        <div>Total Leads</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="text-value-lg">{{ $leads->where('status', 1)->count() }}</div>
                        <div>Pending</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="text-value-lg">{{ $leads->where('status', 2)->count() }}</div>
                        <div>Accepted</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="text-value-lg">{{ $leads->where('status', 3)->count() }} /
                            {{ $leads->where('status', 4)->count() }}</div>
                        <div>On-hold / Rejected</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between flex-wrap">
                <div>
                    <h2 class="font-weight-bold h3">{{ $client->name }}'s Leads</h2>
                    <p class="text-muted mb-0"><strong>State: </strong>{{ $client->lead_state_names }}</p>
                    @if(request()->get('filter'))
                        <p class="text-muted mb-0"><strong>Filter: </strong> {{ ucwords(request()->get('filter')) }}</p>
                        @if(request()->get('filter') == 'custom')
                            <p class="text-muted mb-0"><strong>Range: </strong> {{ Carbon\Carbon::parse(request()->get('start'))->format('d-m-Y') }} to {{ Carbon\Carbon::parse(request()->get('end'))->format('d-m-Y') }}</p>
                        @endif
                    @endif
                </div>
                <div>
                    <h3 class="font-weight-bold h4 text-center">Leads Filtering</h3>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a class="btn btn-info" href="{{ route('client.leads', $client) }}?filter=this-week">This
                            Week</a>
                        <a class="btn btn-primary" href="{{ route('client.leads', $client) }}?filter=last-week">Last
                            Week</a>
                        <button type="button" class="btn btn-warning" data-toggle="modal"
                            data-target="#CustomFilterModal">Custom</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="allLeads" class="table table-striped table-responsive-lg" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>State</th>
                            <th>Contact</th>
                            <th>Quote Type</th>
                            <th>Call Center</th>
                            @if (!request()->routeIs('leads.assigned_leads', 'leads.created_leads'))
                                <th>Agent</th>
                            @endif
                            <th>Attached At</th>
                            <th>Assign Type</th>
                            <th class="text-center">Lead Status</th>
                            <th class="text-center">Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            <tr style="@if(!in_array($lead->state_model->id, $lead->client->lead_states))color: #721c24; background-color: #f8d7da; @endif @if($lead->status == '4')  background-color: #eb7a7a; color: #fff; @endif">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $lead->state }}</td>
                                <td>
                                    {{ $lead->name }}
                                    <div><strong>Phone: </strong> {{ $lead->phone }}</div>
                                </td>
                                <td data-order="{{ $lead->quote }}">{{ ucwords($lead->quote_type) }}</td>
                                @if (!(auth()->user()->hasRole('client') || auth()->user()->hasRole('client agent')))
                                    <td>
                                        @if ($lead->call_center)
                                            <a
                                                href="{{ route('call-center.show', $lead->call_center) }}">{{ ucfirst($lead->call_center->center_name) }}</a>
                                        @else
                                            @if ($lead->call_center_id)
                                                Deleted
                                            @else
                                                NA
                                            @endif
                                        @endif
                                    </td>
                                    @if (!request()->routeIs('leads.assigned_leads', 'leads.created_leads'))
                                    <td>
                                        @if ($lead->agent)
                                            <a
                                                href="{{ route('call-center.show', $lead->agent) }}">{{ $lead->agent->name }}</a>
                                        @else
                                            @if ($lead->agent_id)
                                                Deleted
                                            @else
                                                NA
                                            @endif
                                        @endif
                                    </td>
                                    @endif
                                @endif
                                <td>{!! $lead->assigned_time ? $lead->assigned_time->setTimezone(auth()->user()->timezone)->format('d M Y \<\b\r\>h:i:s A') : 'NA' !!}</td>
                                <td>{{ ucwords($lead->assign_type_text) }}</td>
                                @php
                                    $status_class = 'badge-info';

                                    switch ($lead->status) {
                                        case 1:
                                            $status_class = 'badge-warning text-white';
                                            break;
                                        case 2:
                                            $status_class = 'badge-success';
                                            break;
                                        case 3:
                                            $status_class = 'badge-info';
                                            break;
                                        case 4:
                                            $status_class = 'badge-danger';
                                            break;
                                    }
                                @endphp
                                <td class="text-center" data-order="{{ $lead->status }}">
                                    <span class="badge {{ $status_class }}"
                                        style="font-size: 12px;">{{ $lead->status_text }}</span>
                                </td>

                                @php
                                    $payment_status_class = 'badge-info';

                                    switch ($lead->payment_status) {
                                        case 1:
                                            $payment_status_class = 'badge-warning text-white';
                                            break;
                                        case 2:
                                            $payment_status_class = 'badge-success';
                                            break;
                                        case 3:
                                            $payment_status_class = 'badge-info';
                                            break;
                                        case 4:
                                            $payment_status_class = 'badge-danger';
                                            break;
                                    }
                                @endphp
                                <td class="text-center" data-order="{{ $lead->payment_status }}">
                                    <span class="badge {{ $payment_status_class }}"
                                        style="font-size: 12px;">{{ $lead->payment_status_text }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="User actions">
                                        <a class="btn btn-primary" href="{{ route('leads.show', $lead) }}">View</a>
                                        <button class="btn btn-info" type="button" data-toggle="modal"
                                            data-target="#updateStatus_{{ $lead->id }}">Update Status</button>
                                        <button class="btn btn-success" type="button" data-toggle="modal"
                                            data-target="#updatePaymentStatus_{{ $lead->id }}">Update Payment
                                            Status</button>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="updateStatus_{{ $lead->id }}" tabindex="-1"
                                style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog modal-info" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('leads.update_status', $lead) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirm Update Status?</h4>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="status_{{ $lead->id }}">Status</label>
                                                    <select name="status" id="status_{{ $lead->id }}"
                                                        class="form-control">
                                                        <option value="">Select status value</option>
                                                        @foreach (App\Models\Lead::$statuses as $key => $value)
                                                            @if ($lead->status != $key)
                                                                <option value="{{ $key }}"
                                                                    @if ($lead->status == $key) selected @endif>{{ $value }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="note">Note</label>
                                                    <textarea name="note" id="note_{{ $lead->id }}"
                                                        class="form-control" rows="10"
                                                        placeholder="Enter any additional note that should be attached to lead..."
                                                        maxlength="500">{{ $lead->note }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Close</button>
                                                <button class="btn btn-info" type="submit">Confirm Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="updatePaymentStatus_{{ $lead->id }}" tabindex="-1"
                                style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog modal-success" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('leads.update_payment_status', $lead) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirm Update Payment Status?</h4>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="payment_status_{{ $lead->id }}">Status</label>
                                                    <select name="payment_status"
                                                        id="payment_status_{{ $lead->id }}" class="form-control">
                                                        <option value="">Select status value</option>
                                                        @foreach (App\Models\Lead::$paymentStatuses as $key => $value)
                                                            @if ($lead->payment_status != $key)
                                                                <option value="{{ $key }}"
                                                                    @if ($lead->payment_status == $key) selected @endif>{{ $value }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="payment_note">Note</label>
                                                    <textarea name="payment_note" id="payment_note_{{ $lead->id }}"
                                                        class="form-control" rows="10"
                                                        placeholder="Enter any additional note that should be attached to lead..."
                                                        maxlength="500">{{ $lead->payment_note }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Close</button>
                                                <button class="btn btn-success" type="submit">Confirm Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Custom Filter -->
        <div class="modal fade" id="CustomFilterModal" tabindex="-1" role="dialog"
            aria-labelledby="CustomFilterModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('client.leads', $client) }}" method="GET">
                        <div class="modal-header">
                            <h5 class="modal-title" id="CustomFilterModalLabel">Custom Filter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="filter" value="custom">

                            <div class="form-group">
                                <label for="date">Start Date</label>
                                <input type="date" class="form-control" id="date" name="start"
                                    placeholder="Enter the start date" max="{{ now()->subDay()->format('Y-m-d') }}">
                            </div>

                            <div class="form-group">
                                <label for="date">End Date</label>
                                <input type="date" class="form-control" id="date" name="end"
                                    placeholder="Enter the end date" max="{{ now()->addDay()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
