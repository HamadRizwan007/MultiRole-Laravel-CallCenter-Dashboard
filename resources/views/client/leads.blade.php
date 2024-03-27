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

                $('#updateLeads').DataTable();



                if (document.getElementById('state')) {

                    new SlimSelect({

                        select: "#state"

                    });

                }

                const AllLeads = () => {

                   let leads =  document.querySelectorAll('.status');

                    leads.forEach(lead => {

                        lead.value = 2;

                        lead.setAttribute('selected', 'selected');

                        console.log(lead);

                    });

                }

                const AllPayments = () => {

                   let payments =  document.querySelectorAll('.payment_status');

                    payments.forEach(payment => {

                        payment.value = 2;

                        payment.setAttribute('selected', 'selected');

                        console.log(payment);

                    });

                }



                document.getElementById('AllLeads').addEventListener('click', AllLeads);

                document.getElementById('AllPayments').addEventListener('click', AllPayments);

            });

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

                    <p class="text-muted mb-0"><strong>Range: </strong> {{

                        Carbon\Carbon::parse(request()->get('start'))->format('d-m-Y') }} to {{

                        Carbon\Carbon::parse(request()->get('end'))->format('d-m-Y') }}</p>

                    @endif

                    @endif

                </div>

                <div class="d-flex">

                    <div class="mr-2">

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

                    <div>

                        <h3 class="font-weight-bold h4 text-center">Bulk Actions</h3>

                        <div class="btn-group" role="group" aria-label="Basic example">

                            <button type="button" class="btn btn-success" data-toggle="modal"

                                data-target="#bulkUpdateModal">Update</button>

                            <button type="button" class="btn btn-danger" data-toggle="modal"

                                data-target="#generateInvoiceModal">Generate Invoice</button>

                        </div>

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

                        <tr

                            style="@if(!in_array($lead->state_model->id, $lead->client->lead_states))color: #721c24; background-color: #f8d7da; @endif @if($lead->status == '4')  background-color: #eb7a7a; color: #fff; @endif">

                            <td>{{ $leads->firstItem()+$loop->index }}</td>

                            <td>{{ $lead->state }}</td>

                            <td>

                                {{ $lead->name }}

                                <div><strong>Phone: </strong> {{ $lead->phone }}</div>

                            </td>

                            <td data-order="{{ $lead->quote }}">{{ ucwords($lead->quote_type) }}</td>

                            @if (!(auth()->user()->hasRole('client') || auth()->user()->hasRole('client agent')))

                            <td>

                                @if ($lead->call_center)

                                <a href="{{ route('call-center.show', $lead->call_center) }}">{{

                                    ucfirst($lead->call_center->center_name) }}</a>

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

                                <a href="{{ route('call-center.show', $lead->agent) }}">{{ $lead->agent->name }}</a>

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

                            <td>{!! $lead->assigned_time ?

                                $lead->assigned_time->setTimezone(auth()->user()->timezone)->format('d M Y \<\b\r\>h:i:s

                                    A') : 'NA' !!}</td>

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

                                <span class="badge {{ $status_class }}" style="font-size: 12px;">{{ $lead->status_text

                                    }}</span>

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

                                <span class="badge {{ $payment_status_class }}" style="font-size: 12px;">{{

                                    $lead->payment_status_text }}</span>

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

                        <div class="modal fade" id="updateStatus_{{ $lead->id }}" tabindex="-1" style="display: none;"

                            aria-modal="true" role="dialog">

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

                                                <select name="status" id="status_{{ $lead->id }}" class="form-control">

                                                    <option value="">Select status value</option>

                                                    @foreach (App\Models\Lead::$statuses as $key => $value)

                                                    @if ($lead->status != $key)

                                                    <option value="{{ $key }}" @if ($lead->status == $key) selected

                                                        @endif>{{ $value }}

                                                    </option>

                                                    @endif

                                                    @endforeach

                                                </select>

                                            </div>

                                            <div class="form-group">

                                                <label for="note">Note</label>

                                                <textarea name="note" id="note_{{ $lead->id }}" class="form-control"

                                                    rows="10"

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

                                    <form action="{{ route('leads.update_payment_status', $lead) }}" method="POST">

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

                                                <select name="payment_status" id="payment_status_{{ $lead->id }}"

                                                    class="form-control">

                                                    <option value="">Select status value</option>

                                                    @foreach (App\Models\Lead::$paymentStatuses as $key => $value)

                                                    @if ($lead->payment_status != $key)

                                                    <option value="{{ $key }}" @if ($lead->payment_status == $key)

                                                        selected @endif>{{ $value }}

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
                {{ $leads->links() }}

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

        {{-- adding update to leads table --}}

        <div class="modal fade" id="bulkUpdateModal" tabindex="-1" role="dialog" aria-labelledby="bulkUpdateModalLabel"

            aria-hidden="true">

            <div class="modal-dialog modal-xl" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="bulkUpdateModalLabel">Bulk Update</h5>

                        <div class="d-flex">

                            <button type="button" id="AllLeads" class="btn btn-success mr-3">

                                Accept All leads

                            </button>

                            <button type="button" id="AllPayments" class="btn btn-primary">

                                Accept all Payments

                            </button>

                        </div>

                    </div>

                    <form action="{{route('client.bulk_update')}}" method="POST" enctype="multiple/form-data">

                        @csrf

                        @method('PATCH')

                        <div class="modal-body">

                            {{-- table start here --}}

                            <table id="updateLeads" class="table table-striped table-responsive-lg" style="width:100%">

                                <thead>

                                    <tr>

                                        <th>Sr #</th>

                                        <th>State</th>

                                        <th>Contact</th>

                                        <th>Quote Type</th>

                                        <th>Call Center / <br>

                                            @if (!request()->routeIs('leads.assigned_leads', 'leads.created_leads'))

                                            Agent

                                            @endif

                                        </th>

                                        <th>Attached At</th>

                                        <th>Assign Type</th>

                                        <th class="text-center" style="width: 70px !important">Lead Status</th>

                                        <th class="text-center">Payment Status</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($leads as $lead)

                                    <tr

                                        style="@if(!in_array($lead->state_model->id, $lead->client->lead_states))color: #721c24; background-color: #f8d7da; @endif @if($lead->status == '4')  background-color: #eb7a7a; color: #fff; @endif">

                                        <td>{{ $loop->index + 1 }}</td>

                                        <td>{{ $lead->state }}</td>

                                        <td>

                                            {{ $lead->name }}

                                            <div><strong>Phone: </strong> {{ $lead->phone }}</div>

                                        </td>

                                        <td data-order="{{ $lead->quote }}">{{ ucwords($lead->quote_type) }}</td>

                                        @if (!(auth()->user()->hasRole('client') || auth()->user()->hasRole('client

                                        agent')))

                                        <td>

                                            @if ($lead->call_center)

                                            <a href="{{ route('call-center.show', $lead->call_center) }}">{{

                                                ucfirst($lead->call_center->center_name) }}</a>

                                            @else

                                            @if ($lead->call_center_id)

                                            Deleted

                                            @else

                                            NA

                                            @endif

                                            @endif

                                            <br>

                                            @if (!request()->routeIs('leads.assigned_leads', 'leads.created_leads'))

                                            {{--

                                        <td> --}}

                                            @if ($lead->agent)

                                            <a href="{{ route('call-center.show', $lead->agent) }}">{{

                                                $lead->agent->name

                                                }}</a>

                                            @else

                                            @if ($lead->agent_id)

                                            Deleted

                                            @else

                                            NA

                                            @endif

                                            @endif

                                            {{--

                                        </td> --}}

                                        @endif

                                        @endif



                                        </td>

                                        {{-- @if (!request()->routeIs('leads.assigned_leads', 'leads.created_leads'))

                                        <td>

                                            @if ($lead->agent)

                                            <a href="{{ route('call-center.show', $lead->agent) }}">{{

                                                $lead->agent->name

                                                }}</a>

                                            @else

                                            @if ($lead->agent_id)

                                            Deleted

                                            @else

                                            NA

                                            @endif

                                            @endif

                                        </td>

                                        @endif

                                        @endif --}}

                                        <td>{!! $lead->assigned_time ?

                                            $lead->assigned_time->setTimezone(auth()->user()->timezone)->format('d M Y \

                                            <\b\r\>h:i:s

                                                A') : 'NA' !!}

                                        </td>

                                        <td>{{ ucwords($lead->assign_type_text) }}</td>



                                        <td class="text-center" data-order="{{ $lead->status }}">

                                            <select name="statuses[{{$lead->id}}][lead_status]" id="status"

                                                class="form-control status">

                                                <option value="">Select status value</option>

                                                @foreach (App\Models\Lead::$statuses as $key => $value)

                                                <option value="{{ $key }}" @if ($lead->status == $key) selected

                                                    @endif>{{ $value }}

                                                </option>

                                                @endforeach

                                            </select>

                                        </td>

                                        <td class="text-center" data-order="{{ $lead->payment_status }}">

                                            <select name="statuses[{{$lead->id}}][payment_status]" id="payment_status"

                                                class="form-control payment_status">

                                                <option value="">Select status value</option>

                                                @foreach (App\Models\Lead::$paymentStatuses as $key =>

                                                $value)

                                                <option value="{{ $key }}" @if ($lead->payment_status ==

                                                    $key)

                                                    selected @endif>{{ $value }}

                                                </option>

                                                @endforeach

                                            </select>

                                        </td>

                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>

                            {{-- table end here --}}

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-primary">Update Data</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        {{-- adding update end here --}}



        {{-- adding generate invoice --}}

        <div class="modal fade" id="generateInvoiceModal" tabindex="-1" role="dialog"

            aria-labelledby="bulkUpdateModalLabel" aria-hidden="true">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="generateInvoiceModalLabel">Generate Your Invoice </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <form action="{{route('client.generate_invoice', $client)}}" method="POST" enctype="multiple/form-data">

                        @csrf

                        <div class="modal-body">

                            {{-- data start here --}}

                            <div class="row">

                                <div class="form-group col-md-6">

                                    <label for="invoice_number">Invoice Number</label>

                                    <input class="form-control @error('invoice_number') is-invalid @enderror"

                                        id="invoice_number" name="invoice_number" type="text"

                                        placeholder="Enter invoice number" value="{{ old('invoice_number') }}" required>

                                    @error('invoice_number')

                                    <div class="invalid-feedback">{{ $message }}</div>

                                    @enderror

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="lead_request">Lead Request</label>

                                    <select name="lead_request" class="form-control @error('lead_request') is-invalid @enderror" required>

                                        <option value="">Select status value</option>

                                        @foreach (App\Models\Lead::$assignTypes as $key => $value)

                                        <option value="{{ $value }}">{{ ucwords($value) }}

                                        </option>

                                        @endforeach

                                    </select>

                                    @error('lead_request')

                                    <div class="invalid-feedback">{{ $message }}</div>

                                    @enderror

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="state">State</label>

                                    <select name="state[]" id="state" multiple

                                        class="@error('state') is-invalid @enderror">

                                        <option value="">Select State</option>

                                        @foreach ($lead_states as $key => $state)

                                        <option value="{{ $state }}" selected>{{ $state}}

                                        </option>

                                        @endforeach

                                    </select>

                                    @error('state')

                                    <div class="invalid-feedback font-weight-bold text-xsmall">{{ $message }}</div>

                                    @enderror

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="date">Due Date</label>

                                    <input type="date" class="form-control" id="date" name="due_date"

                                        placeholder="Enter the date"

                                        value="{{ now()->next(Carbon\Carbon::MONDAY)->format('Y-m-d') }}">

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="total_leads">Total Leads</label>

                                    <input class="form-control @error('total_leads') is-invalid @enderror"

                                        id="total_leads" name="total_leads" type="text" placeholder="Total Leads"

                                        readonly value="{{ $total_leads }}" required>

                                    @error('total_leads')

                                    <div class="invalid-feedback">{{ $message }}</div>

                                    @enderror

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="billable_leads">Billable Leads</label>

                                    <input class="form-control @error('billable_leads') is-invalid @enderror"

                                        id="billable_leads" readonly name="billable_leads" type="text"

                                        placeholder="Total Leads" value="{{ $billable_leads }}" required>

                                    @error('billable_leads')

                                    <div class="invalid-feedback">{{ $message }}</div>

                                    @enderror

                                </div>

                                <div class="form-group col-md-12">

                                    <label for="total_invoice">Total Amount</label>

                                    <input class="form-control @error('total_invoice') is-invalid @enderror"

                                        id="total_invoice" readonly name="total_invoice" type="text"

                                        placeholder="Total Invoice" value="{{$price * $billable_leads}}" required>

                                    @error('total_invoice')

                                    <div class="invalid-feedback">{{ $message }}</div>

                                    @enderror

                                </div>

                                <div class="form-group col-md-12">

                                    <input class="form-control @error('unit_price') is-invalid @enderror"

                                       readonly name="unit_price" type="hidden"

                                        placeholder="Total Invoice" value="{{ $price}}" required>

                                    @error('unit_price')

                                    <div class="invalid-feedback">{{ $message }}</div>

                                    @enderror

                                </div>

                            </div>

                            {{-- data end here --}}

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-primary">Generate Invoice</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        {{-- generate invoice end here --}}

    </div>

</x-dashboard-layout>

