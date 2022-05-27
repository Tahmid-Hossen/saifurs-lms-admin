<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-8">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>File</th>
                    <th>Download</th>
                </tr>
                </thead>
                <tbody>
                @forelse($files as $file)
                    <tr>
                        <td>{{ $file }}</td>
                        <td>
                            <a href="{{ 'https://cdn.saifurs.com.bd/backend/' . $file }}"
                               class="btn btn-info">Download</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">Testing</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h3 class="card-header">
                    Upload Form
                </h3>
                <div class="card-body">

                    @if(session()->has('confirm') && session()->get('confirm') == true)
                        <p class="text-center text-success font-weight-bold">
                            <a href="{{ session()->get('url') }}"> Try Download</a>
                        </p>
                    @elseif(session()->has('confirm') && session()->get('confirm') == false)
                        <p class="text-center text-danger font-weight-bold">
                            {{ session()->get('url') }}
                        </p>
                        @else
                        {{ 'Let\'s try'}}
                        @endif
                        </p>
                        <form action="{{ route('azures.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Select a File</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="validatedCustomFile" name="file"
                                           required>
                                    <label class="custom-file-label" for="validatedCustomFile">Choose file to upload
                                        ...</label>
                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                </div>
                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </center>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>
