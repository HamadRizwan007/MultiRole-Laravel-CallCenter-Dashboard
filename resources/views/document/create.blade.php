<x-dashboard-layout>
    <x-slot name="pageTitle">Upload Document</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('document.personal') }}">Documents</a></li>
        <li class="breadcrumb-item active">Upload Document</li>
    </x-slot>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form class="card" action="{{ route('document.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-header"><strong>Upload Document</strong></div>
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
                            <label for="agreement">Document File</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icofont-photobucket"></i></span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('document') is-invalid @enderror" id="document" name="document" accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                                    <label class="custom-file-label" for="document">Select document file</label>
                                </div>
                            </div>
                            <div class="text-muted">
                                <small>Acceptable types are pdf, docx & xlsx with file size between 5KB to 10MB.</small>
                            </div>
                            <script>
                                const documentInput = document.getElementById('document');
                                documentInput.addEventListener('change', e => {
                                    if(documentInput.files.length > 0){
                                        const documentFile = documentInput.files[0];
                                        const availableTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
                                        document.querySelector('input[name="document"]+label').innerHTML =  documentFile.name;

                                        if(!availableTypes.includes(documentFile.type)){
                                            documentInput.getElementById('fileTypeError').style.display = 'block';
                                            documentInput.getElementById('fileTypeError').innerHTML = "Only supported types are acceptable";
                                            documentInput.getElementById('submitBtn').setAttribute('disabled', true);
                                        } else {
                                            documentInput.getElementById('fileTypeError').style.display = 'none';
                                            documentInput.getElementById('fileTypeError').innerHTML = "";
                                            documentInput.getElementById('submitBtn').removeAttribute('disabled');
                                        }
                                    }
                                });
                            </script>
                            <div class="text-danger" id="fileTypeError" @error('document') style="display: block;" @enderror>
                                @error('agreement')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Upload Document</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
