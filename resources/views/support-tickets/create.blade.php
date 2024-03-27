<x-dashboard-layout>
    <x-slot name="pageTitle">Create Support Ticket</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Support Tickets</a></li>
        <li class="breadcrumb-item active">Create Support Ticket</li>
    </x-slot>

    <div>
        <form class="card" action="{{ route('tickets.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="card-header"><strong>Create Support Ticket</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input class="form-control" id="name" type="text" placeholder="Enter Support Ticket Name" value="{{ auth()->user()->name }}" disabled>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input class="form-control" id="email" type="text" placeholder="Enter Support Ticket Name" value="{{ auth()->user()->email }}" disabled>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="ticket_title">Ticket Title</label>
                        <input class="form-control @error('ticket_title') is-invalid @enderror" id="ticket_title" name="ticket_title" type="text" placeholder="Enter Support Ticket Name" value="{{ old('ticket_title') }}" required>
                        @error('ticket_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group text-left">
                        <label for="reference_image">Reference Image</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icofont-photobucket"></i></span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('reference_image') is-invalid @enderror" id="reference_image" name="reference_image" accept="image/png,image/jpg,image/jpeg">
                                <label class="custom-file-label" for="reference_image">Select Reference Image</label>
                            </div>
                        </div>
                        <div class="text-muted">
                            <small>Acceptable image types are jpeg, jpg and png, size between 10Kb to 1MB.</small>
                        </div>
                        <script>
                            const referenceImage = document.getElementById('reference_image');
                            referenceImage.addEventListener('change', e => {
                                if(referenceImage.files.length > 0){
                                    const referenceImageFile = referenceImage.files[0];
                                    const availableTypes = ['image/png', 'image/jpg', 'image/jpeg'];
                                    document.querySelector('input[name="reference_image"]+label').innerHTML =  referenceImageFile.name;

                                    if(!availableTypes.includes(referenceImageFile.type)){
                                        document.getElementById('fileTypeError').style.display = 'block';
                                        document.getElementById('fileTypeError').innerHTML = "Only supported images files are acceptable";
                                        document.getElementById('submitBtn').setAttribute('disabled', true);
                                    } else {
                                        document.getElementById('fileTypeError').style.display = 'none';
                                        document.getElementById('fileTypeError').innerHTML = "";
                                        document.getElementById('submitBtn').removeAttribute('disabled');
                                    }
                                }
                            });
                        </script>
                        <div class="text-danger" id="fileTypeError" @error('reference_image') style="display: block;" @enderror>
                            @error('reference_image')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="10" placeholder="Describe the problem you are facing here....">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Create</button>
            </div>
        </form>
    </div>
</x-dashboard-layout>
