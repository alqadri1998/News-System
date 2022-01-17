@extends('cms.admin.parent')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin - Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Update Admin</li>
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
                                <h3 class="card-title">Update Admin</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" method="post" id="update_admin_form">
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
                                                <option value="{{$category->id}}"
                                                        @if($article->category_id == $category->id) selected @endif>
                                                    {{$category->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Author</label>
                                        <select id="author_id" class="form-control select2bs4" style="width: 100%;">
                                            <option value="" selected disabled hidden>Select Author</option>
                                            @foreach ($authors as $author)
                                                <option value="{{$author->id}}"
                                                        @if($article->author_id == $author->id) selected @endif>{{$author->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input value="{{$article->title}}" type="text"
                                               class="form-control"
                                               id="title" placeholder="Enter title">
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description">Short Desc.</label>
                                        <input value="{{$article->short_description}}" type="tel"
                                               class="form-control"
                                               id="short_description" placeholder="Enter Short Desc.">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Full Desc.</label>
                                        <textarea class="form-control" id="full_description"
                                                  placeholder="Enter Full Desc.">{{$article->full_description}}</textarea>
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
                                        <label>Article Status</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="status"
                                                   id="status"
                                                   @if($article->status == 'Visible') checked @endif>
                                            <label class="custom-control-label" for="status">Visible</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="button" onclick="updateArticle('{{$article->id}}')"
                                            class="btn btn-primary">Save
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
        function updateArticle(id) {
            axios.put('/cms/admin/articles/' + id, {
                category_id: document.getElementById("category_id").value,
                author_id: document.getElementById("author_id").value,
                title: document.getElementById("title").value,
                short_description: document.getElementById("short_description").value,
                full_description: document.getElementById("full_description").value,
                status: document.getElementById("status").checked === true ? "Visible" : "InVisible",
            })
                .then(function (response) {
                    // clearAndHideErrors();
                    showMessage(response.data);
                })
                .catch(function (error) {
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
            var errorMessagesUl = document.getElementById("error_messages_ul");
            errorMessagesUl.innerHTML = '';
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
