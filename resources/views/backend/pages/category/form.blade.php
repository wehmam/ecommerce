@extends("backend.layouts")
@section("title", "Dashboard")
@section("content-title", "Form Category")
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endsection
@section("content")

<!-- DataTales Example -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Category</h6>
        </div>
        <div class="card-body">
            <form action="{{ Request::segment(3) == "create" ? url("backend/category") : url("backend/category/" . $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(Request::segment(3) != "create")
                    <input type="hidden" name="_method" value="PUT">
                @endif
                <input type="hidden" name="" id="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="slug">Category Name</label>
                            <input type="text" class="form-control" name="name" value="{{ isset($category) ? $category['name'] : old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="is_active">Active</label>
                            <select name="is_active" class="form-control" required>
                                <option value="1" {{ isset($category) ? ($category->is_active == 1 ? "active" : "") : (old('is_active') == 1 ? "selected" : "") }}>Yes</option>
                                <option value="0" {{ isset($category) ? ($category->is_active == 0 ? "active" : "") : (old('is_active') == 0 ? "selected" : "") }}>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="main_image">Main Image</label>
                            <input type="file" name="main_image" class="form-control" onchange="loadFile(event)">
                        </div>
                        <div class="card mb-5 mt-2" id="cardImage" {{ isset($category) ? "" : "hidden" }}>
                            <img  src="{{ isset($category) ? $category->main_image  : '' }}" class="card-img-top" id="output" alt="Card image cap">
                          </div>
                    <a href="{{ url("backend/category") }}" class="btn btn-sm btn-warning">Back</a>
                        <button type="submit" class="btn btn-sm btn-primary float-right">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        const sessionStatus  = "{{ Session::has('status') }}"
        const sessionMessage = "{{ Session::get('status') }}"
        const sessionClass   = "{{ Session::get('alert-class') }}"
        console.log("session class " + sessionClass)
        if(sessionStatus) {
            Swal.fire(
                sessionClass == "error" ? "Opps!" : "Success!" ,
                sessionMessage,
                sessionClass
            )
        }

        let loadFile = (event) => {
            document.getElementById("cardImage").removeAttribute("hidden");
            let reader = new FileReader()
            reader.onload = function() {
                let output = document.getElementById("output")
                output.src = reader.result
            };
            console.log(event.target.files[0]);
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
