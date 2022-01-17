@extends('cms.admin.parent')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Article - Create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Article</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Create Article</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" method="post" enctype="multipart/form-data" id="create_article_form">
                                @csrf
                                <div class="card-body">
                                    <div class="alert alert-danger" id="error_alert" role="alert" hidden>
                                        <ul id="error_messages_ul"></ul>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select id="category_id" class="form-control select2bs4" style="width: 100%;">
                                            <option value="" selected disabled hidden>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if(auth('admin')->check())
                                        <div class="form-group">
                                            <label>Author</label>
                                            <select id="author_id" class="form-control select2bs4" style="width: 100%;">
                                                <option value="" selected disabled hidden>Select Author</option>
                                                @foreach ($authors as $author)
                                                    <option value="{{$author->id}}">{{$author->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input value="{{old('title')}}" type="text"
                                               class="form-control"
                                               id="title" placeholder="Enter title">
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description">Short Desc.</label>
                                        <input value="{{old('short_description')}}" type="tel"
                                               class="form-control"
                                               id="short_description" placeholder="Enter Short Desc.">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Full Desc.</label>
                                        <textarea class="form-control" id="full_description"
                                                  placeholder="Enter Full Desc.">{{old('full_description')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="article_image_input">Article Small Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="article_small_image">
                                                <label class="custom-file-label" for="article_image_input">Choose
                                                    file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="article_main_image_input">Article Main Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="article_main_image">
                                                <label class="custom-file-label" for="article_main_image_input">Choose
                                                    file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Account Status</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input"
                                                   id="status"
                                                   @if((old('status')) == 'on') checked @endif>
                                            <label class="custom-control-label" for="status">Active</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="button" onclick="createArticle()" class="btn btn-primary">Save
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        function createArticle() {
            var params = {
                category_id: document.getElementById("category_id").value,
                title: document.getElementById("title").value,
                short_description: document.getElementById("short_description").value,
                full_description: document.getElementById("full_description").value,
                status: document.getElementById("status").checked === true ? "Visible" : "InVisible",
            };

            @if(auth('admin')->check())
                params["author_id"] = document.getElementById("author_id").value;
            @endif

            axios.post('/cms/admin/articles', params)
                .then(function (response) {
                    clearAndHideErrors();
                    clearForm();
                    showMessage(response.data);

                }).catch(function (error) {
                if (error.response.data.errors !== undefined) {
                    showErrorMessages(error.response.data.errors);
                } else {
                    showMessage(error.response.data);
                }
            });
        }

        function showErrorMessages(errors) {
            document.getElementById('error_alert').hidden = false
            var errorMessagesUl = document.getElementById("error_messages_ul");
            errorMessagesUl.innerHTML = '';

            for (var key of Object.keys(errors)) {
                var newLI = document.createElement('li');
                newLI.appendChild(document.createTextNode(errors[key]));
                errorMessagesUl.appendChild(newLI);
            }
        }

        function clearAndHideErrors() {
            document.getElementById('error_alert').hidden = true
            let errorMessagesUl = document.getElementById("error_messages_ul");
            errorMessagesUl.innerHTML = '';
        }

        function clearForm() {
            document.getElementById("create_article_form").reset();
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
