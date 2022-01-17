@extends('cms.admin.parent')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Categories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">News CMS - Categories</h3>
                            @can('create-category')
                                <a href="{{route('categories.create')}}" class="btn btn-sm btn-info float-right">Create
                                    New
                                    Category</a>
                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Name (En)</th>
                                    <th>Name (Ar)</th>
                                    <th>Articles #</th>
                                    <th>Authors #</th>
                                    <th>Status</th>
                                    <th>Create Date</th>
                                    <th>Updated Date</th>
                                    <th>Settings</th>
                                </tr>
                                </thead>
                                <tbody>
                                <span hidden>{{$count = 0}}</span>
                                @foreach($categoriesData as $category)
                                    <tr>
                                        <td><span class="badge badge-info">{{++$count}}</span></td>
                                        <td>{{$category->id}}</td>
                                        <td>{{$category->name_en}}</td>
                                        <td>{{$category->name_ar}}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm"
                                               href="{{route('category.articles',[$category->id])}}">
                                                <i class="fas fa-sticky-note">
                                                </i>
                                                ({{$category->articles_count}}) Article/s
                                            </a>
                                            <span class="badge badge-dark"></span>
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm"
                                               href="{{route('category.authors',[$category->id])}}">
                                                <i class="fas fa-sticky-note">
                                                </i>
                                                ({{$category->authors_count}}) Author/s
                                            </a>
                                            <span class="badge badge-dark"></span>
                                        </td>
                                        <td>
                                            @if($category->status == 'Visible')
                                                <span class="badge badge-success">{{$category->status}}</span>
                                            @else
                                                <span class="badge badge-danger">{{$category->status}}</span>
                                            @endif
                                        </td>
                                        <td>{{$category->created_at}}</td>
                                        <td>{{$category->updated_at}}</td>
                                        <td>
                                            @can('delete-category')
                                                <a href="#" onclick="confirmDelete(this, '{{$category->id}}')"
                                                   class="btn btn-xs btn-danger" style="color: white;">Delete</a>
                                            @endcan
                                            @can('update-category')
                                                <a href="{{route('categories.edit',[$category->id])}}"
                                                   class="btn btn-xs btn-info" style="color: white;">Edit</a>
                                            @endcan
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Name (En)</th>
                                    <th>Name (Ar)</th>
                                    <th>Articles #</th>
                                    <th>Authors #</th>
                                    <th>Status</th>
                                    <th>Create Date</th>
                                    <th>Updated Date</th>
                                    <th>Settings</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row justify-content-center">
                            {{$categoriesData->render()}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('scripts')
    <!-- DataTables -->
    <script src="{{asset('cms/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('cms/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        function confirmDelete(app, id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    deleteCategory(app, id)
                }
            })
        }

        function deleteCategory(app, id) {
            axios.delete('/cms/admin/categories/' + id)
                .then(function (response) {
                    // handle success (Status Code: 200)
                    console.log(response);
                    console.log(response.data);
                    showMessage(response.data);
                    app.closest('tr').remove();
                })
                .catch(function (error) {
                    // handle error (Status Code: 400)
                    console.log(error);
                    console.log(error.response.data);
                    showMessage(error.response.data);
                })
                .then(function () {
                    // always executed
                });
        }

        function showMessage(data) {
            Swal.fire({
                position: 'center',
                icon: data.icon,
                title: data.title,
                showConfirmButton: false,
                timer: 1500
            })
        }
    </script>
@endsection
