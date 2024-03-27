<x-dashboard-layout>
    <x-slot name="pageTitle">Support Tickets</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @if(auth()->user()->can('view all tickets'))
            <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tickets</a></li>
        @else
            <li class="breadcrumb-item"><a href="{{ route('tickets.my-tickets') }}">Tickets</a></li>
        @endif
        <li class="breadcrumb-item active">Index</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allTickets').DataTable();
            });
        </script>
    </x-slot>

    <div>
        <div class="card">
            <div class="card-body">
                @error('comment')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror
                <table id="allTickets" class="table table-striped table-responsive-lg" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td>{{ $tickets->firstItem()+$loop->index }}</td>
                                <td>{{ $ticket->name }}</td>
                                <td>{{ $ticket->email }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td style="font-size: 1rem;" data-order="{{ $ticket->status }}">
                                    @php
                                        $class_name = 'badge-info';
                                        switch ($ticket->status) {
                                            case 1:
                                                $class_name = 'badge-warning text-white';
                                                break;
                                            case 2:
                                                $class_name = 'badge-success text-white';
                                                break;
                                            case 3:
                                                $class_name = 'badge-primary text-white';
                                                break;
                                        }
                                    @endphp
                                    <span class="badge {{ $class_name }}">{{ ucfirst($ticket->status_text) }}</span>
                                </td>
                                <td>{{ $ticket->created_at->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Ticket actions">
                                        <button class="btn btn-info" type="button"  data-toggle="modal" data-target="#viewTicket_{{$ticket->id}}">View</button>

                                        <div class="btn-group">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Update Status</button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="will-change: transform; margin: 0px;">
                                                @if(in_array($ticket->status, [1, 2]) && auth()->user()->can('update tickets'))
                                                    <button class="dropdown-item text-primary" type="button"  data-toggle="modal" data-target="#markInProgress_{{$ticket->id}}">Mark In-Progress</button>
                                                @endif
                                                @if(in_array($ticket->status, [2, 3]) && auth()->user()->can('update tickets'))
                                                    <button class="dropdown-item text-warning" type="button"  data-toggle="modal" data-target="#markPending_{{$ticket->id}}">Mark Pending</button>
                                                @endif
                                                @if(in_array($ticket->status, [3]) && auth()->user()->can('update tickets'))
                                                    <button class="dropdown-item text-success" type="button"  data-toggle="modal" data-target="#markDone_{{$ticket->id}}">Mark Done</button>
                                                @endif
                                            </div>
                                        </div>
                                        @if(auth()->user()->can('delete tickets'))
                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#deleteTicket_{{$ticket->id}}">Delete</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="viewTicket_{{$ticket->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog modal-primary" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Ticket "{{ $ticket->title }}" information</h4>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            @if($ticket->image_url)
                                                <div class="mx-auto mb-3 constrained-image" style="min-height: 200px; max-height: 400px; width: 95%; background-image: url('{{ $ticket->image_url }}')"></div>
                                            @endif

                                            <h5 class="text-center font-weight-bold">{{ $ticket->title }}</h5>
                                            <p class="text-center text-xsmall">
                                                {{ $ticket->name }}<br>
                                                {{ $ticket->email }}
                                            </p>
                                            <h6 class="font-weight-bold">Description:</h6>
                                            <p>{{ ucfirst($ticket->message) }}</p>
                                            @if($ticket->comment)
                                                <h6 class="font-weight-bold mt-3">Admin Comment:</h6>
                                                <p>{{ ucfirst($ticket->comment) }}</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(in_array($ticket->status, [3]) && auth()->user()->can('update tickets'))
                            <div class="modal fade" id="markDone_{{$ticket->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog modal-primary" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('tickets.update-status', $ticket) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="2">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Are you sure?</h4>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to mark the ticket created by <strong>{{ $ticket->name }}</strong> as marked done.</p>

                                                <div class="form-group">
                                                    <label for="markDoneComment">Comment</label>
                                                    <textarea name="comment" id="markDoneComment" class="form-control" rows="10" placeholder="Enter a message you want to send to ticket issuer here...">{{ old('comment', $ticket->comment) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" type="submit">Mark Done</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(in_array($ticket->status, [1, 2]) && auth()->user()->can('update tickets'))
                            <div class="modal fade" id="markInProgress_{{$ticket->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog modal-primary" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('tickets.update-status', $ticket) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="3">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Are you sure?</h4>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to mark the ticket created by <strong>{{ $ticket->name }}</strong> as marked In-Progress.</p>

                                                <div class="form-group">
                                                    <label for="markInProgressComment">Comment</label>
                                                    <textarea name="comment" id="markInProgressComment" class="form-control" rows="10" placeholder="Enter a message you want to send to ticket issuer here...">{{ old('comment', $ticket->comment) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" type="submit">Mark In-Progress</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(in_array($ticket->status, [2, 3]) && auth()->user()->can('update tickets'))
                            <div class="modal fade" id="markPending_{{$ticket->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog modal-primary" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('tickets.update-status', $ticket) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="1">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Are you sure?</h4>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to mark the ticket created by <strong>{{ $ticket->name }}</strong> as marked pending.</p>

                                                <div class="form-group">
                                                    <label for="markPendingComment">Comment</label>
                                                    <textarea name="comment" id="markPendingComment" class="form-control" rows="10" placeholder="Enter a message you want to send to ticket issuer here...">{{ old('comment', $ticket->comment) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" type="submit">Mark Pending</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(auth()->user()->can('delete tickets'))
                                <div class="modal fade" id="deleteTicket_{{$ticket->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-danger" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="status" value="2">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Are you sure?</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete the ticket with title <strong>{{ $ticket->title}}</strong>.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                    <button class="btn btn-danger" type="submit">Confirm Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                {{ $tickets->links()   }}
            </div>
        </div>
    </div>
</x-dashboard-layout>
