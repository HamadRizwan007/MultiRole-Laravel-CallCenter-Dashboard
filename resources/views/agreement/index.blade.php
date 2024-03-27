<x-dashboard-layout>
    <x-slot name="pageTitle">Agreements</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @if(auth()->user()->can('view all agreements'))
            <li class="breadcrumb-item"><a href="{{ route('agreement.index') }}">Agreements</a></li>
        @else
            <li class="breadcrumb-item"><a href="{{ route('agreement.shared') }}">Agreements</a></li>
        @endif
        <li class="breadcrumb-item active">Index</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allAgreements').DataTable();
            });
        </script>
    </x-slot>

    <div>
        <div class="card">
            <div class="card-body">
                <table id="allAgreements" class="table table-striped table-responsive-lg" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Title</th>
                            <th>Accepted</th>
                            @if(auth()->user()->can('create agreement'))
                                <th>Shared to</th>
                                <th>Created By</th>
                            @endif
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agreements as $agreement)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $agreement->title }}</td>
                                <td>
                                    @if($agreement->accepted_on)
                                        {{ $agreement->accepted_on->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}
                                    @else
                                        Not Accepted
                                    @endif
                                </td>
                                @if(auth()->user()->can('create agreement'))
                                    <td>
                                        {{ $agreement->user->name }}
                                        <div class="text-muted">{{ $agreement->user->email }}</div>
                                    </td>
                                    <td>
                                        {{ $agreement->created_by->name }}
                                        <div class="text-muted">{{ $agreement->created_by->email }}</div>
                                    </td>
                                @endif
                                <td>{{ $agreement->created_at->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Ticket actions">
                                        <button class="btn btn-info" onclick="document.getElementById('downloadForm_{{ $agreement->id }}').submit()">Download</button>
                                        @if(auth()->user()->can('accept agreement'))
                                            @if(!$agreement->accepted_on)
                                                <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#acceptAgreement_{{$agreement->id}}">Accept</button>
                                            @endif
                                        @endif
                                        @if(auth()->user()->can('delete agreement'))
                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#deleteAgreement_{{$agreement->id}}">Delete</button>
                                        @endif
                                    </div>
                                    <form action="{{ route('agreement.download', $agreement) }}" id="downloadForm_{{ $agreement->id }}" method="post">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @if(!$agreement->accepted_on && auth()->user()->can('accept agreement'))
                                <div class="modal fade" id="acceptAgreement_{{$agreement->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-primary" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('agreement.accept', $agreement) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Are you sure?</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to accept the agreement with title <strong>{{ $agreement->title }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary" type="submit">Yes, Accept</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(auth()->user()->can('delete agreement'))
                                <div class="modal fade" id="deleteAgreement_{{$agreement->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-danger" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('agreement.destroy', $agreement) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="status" value="2">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Are you sure?</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete the agreement with title <strong>{{ $agreement->title}}</strong>?</p>
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
            </div>
        </div>
    </div>
</x-dashboard-layout>
