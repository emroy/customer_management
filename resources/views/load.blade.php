@extends('layouts.app')

@section('styles')
@parent
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <style>
        form{border:none !important;}
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Load Files</div>

                <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            Please make sure <b>csv</b> file has labels with the correct nomenclature<br>
                            <b>email</b> |
                            <b>first_name</b> |
                            <b>last_name</b> |
                            <b>postcode</b>
                        </div>
                        <form class="dropzone" id="dropzone-load">
                        {{ csrf_field() }}
                        </form>
                         <div style="display:none" id="processing" class="waiting alert alert-info" role="alert">
                            Processing...
                        </div>
                        <div style="display:none" id="ignored" class="alert alert-warning" role="alert">
                            <b>The files above have been ignored due to duplicate email:</b>
                            <div class="duplicates">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent
    <script>

        Dropzone.options.dropzoneLoad = {
            maxFilesize: 10,
            addRemoveLinks: true,
            autoProcessQueue: true,
            acceptedFiles: "text/csv",
            autoQueue: true,
            url: "{{ route('save_files') }}",
            success: function (file, response) {
                if(response.success){
                    Swal.fire("All Done", "Customers Added Successfully", "success");
                    $(".waiting").fadeOut();
                    let ignored = JSON.parse(response.ignored);
                    if(ignored.length > 0){
                        $.each(ignored, (_, i) => {
                            $(".duplicates").append(`<span>${i[response.labels['email']]}, ${i[response.labels['first_name']]} ${i[response.labels['last_name']]} </span><br>`)
                        });
                        $("#ignored").fadeIn();
                    }
                }
            },
            accept: function(file, done) {
                done();
            },
            init: function() {
                this.on("addedfile", file => {
                    $(".waiting").fadeIn();
                    $(".duplicates").html("");
                });
                this.on('error' ,(file, message) => {
                    $(".waiting").fadeOut();
                });
            }
            
        }
    
    </script>

@endsection
