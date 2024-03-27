<x-dashboard-layout>
    <x-slot name="pageTitle">Documents</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @if(auth()->user()->can('view all documents'))
            <li class="breadcrumb-item"><a href="{{ route('document.index') }}">Documents</a></li>
        @else
            <li class="breadcrumb-item"><a href="{{ route('document.personal') }}">Documents</a></li>
        @endif
        <li class="breadcrumb-item active">Index</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allDocuments').DataTable();
            });
        </script>
    </x-slot>

    <div>
        <div class="card">
            <div class="card-body">
                <table id="allDocuments" class="table table-striped table-responsive-lg" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Title</th>
                            @if(auth()->user()->can('view all document'))
                                <th>Created By</th>
                            @endif
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $document)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $document->title }}</td>
                                @if(auth()->user()->can('view all document'))
                                    <td>
                                        {{ $document->created_by->name }}
                                        <div class="text-muted">{{ $document->created_by->email }}</div>
                                    </td>
                                @endif
                                <td>{{ $document->created_at->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Ticket actions">
                                        <button class="btn btn-info" onclick="document.getElementById('downloadForm_{{ $document->id }}').submit()">Download</button>
                                        @if(auth()->user()->can('accept document'))
                                            @if(!$document->accepted_on)
                                                <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#acceptAgreement_{{$document->id}}">Accept</button>
                                            @endif
                                        @endif
                                        @if(auth()->user()->can('delete document'))
                                            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#deleteAgreement_{{$document->id}}">Delete</button>
                                        @endif
                                    </div>
                                    <form action="{{ route('document.download', $document) }}" id="downloadForm_{{ $document->id }}" method="post">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @if(auth()->user()->can('delete document'))
                                <div class="modal fade" id="deleteAgreement_{{$document->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-danger" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('document.destroy', $document) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="status" value="2">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Are you sure?</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete the document with title <strong>{{ $document->title}}</strong>?</p>
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
