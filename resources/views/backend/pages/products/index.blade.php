@extends("backend.layouts")
@section("title", "Dashboard")
@section("content-title", "Products")
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endsection
@section("content")

<!-- DataTales Example -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Product <span class="float-right"> <a href="{{ url("backend/product/create") }}" class="btn btn-success btn-sm" ><i class="fa fa-plus">Add Products</i></a></span></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @forelse ($products as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>Rp.{{ number_format($item->price, 0) }}</td>
                                <td><a class="badge badge-{{ $item->is_active ? "success" : "danger" }}">{{ $item->is_active ? "Yes" : "No" }}</a></td>
                                <td>
                                    <form method="POST" onsubmit="confirm('Are You sure want to delete this data?')" action="{{ url('/backend/product/' . $item->id) }}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <a href="{{ url("/backend/product/" . $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                    </form>
                                </td>
                            </tr>
                       @empty
                           <tr>
                               <td colspan="7" class="text-center">Data Not Found!</td>
                           </tr>
                       @endforelse
                    </tbody>
                </table>
                <div class="text-center">
                    {!! $products->appends($_GET)->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="onSubmit">
            <div class="modal-body">
                <div class="form-group">
                    <label for="category-name" class="col-form-label">Category Name</label>
                    <input type="text" name="name" class="form-control" id="category-name">
                </div>
                <div class="form-group">
                    <label for="slug-category" class="col-form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" id="slug-category">
                </div>
                <div class="form-group">
                    <label for="active-product" class="col-form-label">Active</label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="slug-category" class="col-form-label">Slug</label>
                    <input type="file" name="main_image" class="form-control" id="main_image">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
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

        if(sessionStatus) {
            Swal.fire(
                sessionClass == "danger" ? "Opps!" : "Success!" ,
                sessionMessage,
                sessionClass
            )
        }

        $('#onSubmit').submit((e) => {
            let category     = $('#category-name').val();
            let categorySlug = $('#slug-category').val();
            let isActive    = $('#is_active').val();
            let mainImage   = $('#main_image').files();

            console.log(mainImage)


            e.preventDefault();
            return false;
        })

    </script>
@endsection
