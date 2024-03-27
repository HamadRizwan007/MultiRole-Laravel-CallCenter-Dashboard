<x-dashboard-layout>
    <x-slot name="pageTitle">Create Agreement</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('agreement.index') }}">Agreements</a></li>
        <li class="breadcrumb-item active">Create Agreement</li>
    </x-slot>
    <x-slot name="scripts">
        <script>
            $(document).ready(function(){
                if(document.getElementById('selectUser')){
                    new SlimSelect({ select: '#selectUser' })
                }
            });
        </script>
    </x-slot>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form class="card" action="{{ route('agreement.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-header"><strong>Create Client</strong></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="title">Title</label>
                            <input class="form-control @error('title') is-invalid @enderror" id="title" name="title" type="text" placeholder="Enter the agreement title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 form-group text-left">
                            <label for="agreement">Agreement</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icofont-photobucket"></i></span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('agreement') is-invalid @enderror" id="agreement" name="agreement" accept="'application/pdf','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'" required>
                                    <label class="custom-file-label" for="agreement">Select agreement file</label>
                                </div>
                            </div>
                            <div class="text-muted">
                                <small>Acceptable types are pdf, docx & xlsx with file size between 5KB to 10MB.</small>
                            </div>
                            <script>
                                const agreement = document.getElementById('agreement');
                                agreement.addEventListener('change', e => {
                                    if(agreement.files.length > 0){
                                        const agreementFile = agreement.files[0];
                                        const availableTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
                                        document.querySelector('input[name="agreement"]+label').innerHTML =  agreementFile.name;

                                        if(!availableTypes.includes(agreementFile.type)){
                                            document.getElementById('fileTypeError').style.display = 'block';
                                            document.getElementById('fileTypeError').innerHTML = "Only supported types are acceptable";
                                            document.getElementById('submitBtn').setAttribute('disabled', true);
                                        } else {
                                            document.getElementById('fileTypeError').style.display = 'none';
                                            document.getElementById('fileTypeError').innerHTML = "";
                                            document.getElementById('submitBtn').removeAttribute('disabled');
                                        }
                                    }
                                });
                            </script>
                            <div class="text-danger" id="fileTypeError" @error('agreement') style="display: block;" @enderror>
                                @error('agreement')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="user">Select User</label>
                            <select name="user" id="selectUser">
                                <option value="" selected>User - [Type]</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @if(old('user') == $user->id) selected @endif>{{ $user->name }} - [{{ ucwords($user->roles->first()->name) }}]</option>
                                @endforeach
                            </select>
                            @error('user')
                                <div class="text-danger text-xsmall">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Share Agreement</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
