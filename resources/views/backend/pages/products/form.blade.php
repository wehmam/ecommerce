@extends("backend.layouts")
@section('title', 'Dashboard')
@section('content-title', 'Form Product')
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px !important;
            /* padding: 10px 16px; */
            padding: 5px;
            /* font-size: 18px;  */
            line-height: 1.33;
            border-radius: 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            top: 75% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #CCC !important;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        }

        .delete-price-type-range-field {
            color: red;
        }
        .delete-price-type-range-field:hover {
            color: red;
            cursor: pointer;
        }

    </style>
@endsection
@section('content')

    <!-- DataTales Example -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Product</h6>
            </div>
            <div class="card-body">
                <form action="{{ Request::segment(3) == "create" ? url("backend/product") : url("backend/product/" . $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(Request::segment(3) != "create")
                        <input type="hidden" name="_method" value="PUT">
                    @endif
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="categoryForm">Category</label>
                            <select name="category_id" class="form-control" id="categoryForm" required>
                                <option value="" selected disabled>Select category</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}" {{ isset($product) ? ($product->category_id == $item->id ? "selected" : "") : "" }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="title">Title</label>
                            <input type="text" name="title" value="{{ isset($product) ? $product->title : old("title") }}" class="form-control" id="title" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" name="qty" value="{{ isset($product) ? $product->qty : old("qty") }}" id="quantity" placeholder="ex: 1" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" value="{{ isset($product) ? $product->price : old("price") }}" id="price" placeholder="Ex : 100000" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desciption">Description</label>
                        <textarea name="description" id="description" class="form-control" cols="10" rows="5">{{ isset($product) ? $product->description : old("description") }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="productActive">Product Active</label>
                        <select name="is_active" class="form-control" id="isActive" required>
                            <option value="1" {{ isset($product) ? ($product->is_active ? "selected" : "") : "" }}>Yes</option>
                            <option value="0" {{ isset($product) ? (!$product->is_active ? "selected" : "") : "" }}>No</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="productActive">Product Images</label>
                        <span class=" ml-2">
                            <a class="btn btn-sm btn-success" id="photo-add-id" data-key="999"><i class="fa fa-plus"></i></a>
                        </span>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="file" name="upload_image[]" class="form-control rounded-8px product_image" {{ isset($product) ? "" :"required" }}>
                                </div>
                            </div>
                        </div>
                        <div id="photo-new" class="row"></div>
                    </div>
                    @if(isset($product))
                        <div class="form-group">
                            <h3 class="mb-3">Old Photos</h3>
                            <div class="row">
                                @foreach ($product->productPhotos as $item)
                                    <div class="col-md-8 mb-2">
                                        <img class="img-thumbnail" width="200px" src="{{ Storage::url($item->image) }}" alt="Card image">
                                    </div>
                                    <div class="col-md-2 ">
                                        <a class="delete-price-type-range-field" style="background: transparent" onclick="deleteOldPhoto({{ $item->id }})">
                                            <i class="fa fa-2x fa-trash"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categoryForm').select2();
                $(document).on("click", "#photo-add-id", function (e) {
                e.preventDefault();
                var field     = $("#photo-new");
                const html      =
                `
                <div class="row" id="photo-new">
                    <div class="col-md-10">
                        <div class="form-group">
                            <input type="file" name="upload_image[]" class="form-control rounded-8px product_image" required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <td class="align-right" id="trush">
                            <a  data-key="'+ i +'" class="delete-price-type-range-field" style="background: transparent" onclick="removeField()">
                                <i class="fa fa-2x fa-trash"></i>
                            </a>
                        <td>
                    </div>
                </div>
                `;
                $(html).insertBefore(field);
            });
        });

        $(document).on("change", ".product_image", function (e) {
            e.preventDefault();

            var fileType = this.files[0].type;
            var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
            if ($.inArray(fileType, ValidImageTypes) < 0) {
                Swal.fire(
                    'Oops...',
                    "Hanya bisa upload file berformat jpg/png/gif",
                    'warning'
                )
                $(this).val("");
            }

        });
        const sessionStatus = "{{ Session::has('status') }}"
        const sessionMessage = "{{ Session::get('status') }}"
        const sessionClass = "{{ Session::get('alert-class') }}"
        console.log("session class " + sessionClass)
        if (sessionStatus) {
            Swal.fire(
                sessionClass == "error" ? "Opps!" : "Success!",
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

        function removeField(){
            $("#photo-new").remove()
        }

        function deleteOldPhoto(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't Delete This Photo!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete!'
                }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ url("/backend/product/delete-photo") }}' + "/" +id, {
                        headers: {
                            'content-type'      : 'application/json',
                            'Accept'            : 'application/json',
                            'X-Requested-With'  : 'XMLHttpRequest',
                            'X-CSRF-Token'      : '{{ csrf_token() }}',
                        },
                        method: 'DELETE',
                    })
                    .then(res => {
                        window.location.reload()
                    })
                }
            })
        }
    </script>
@endsection
