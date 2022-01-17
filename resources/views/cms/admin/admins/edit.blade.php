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
                                        <label for="exampleInputEmail1">Full Name</label>
                                        <input id="name" value="{{$admin->name}}" type="text"
                                               class="form-control"
                                               placeholder="Enter name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Email</label>
                                        <input id="email" value="{{$admin->email}}" type="email"
                                               class="form-control" placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Mobile</label>
                                        <input id="mobile" value="{{$admin->mobile}}" type="tel"
                                               class="form-control" placeholder="Enter mobile">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Age</label>
                                        <input id="age" value="{{$admin->age}}" type="number"
                                               class="form-control" placeholder="Enter age">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Gender</label>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="Male"
                                                   name="gender" value="Male"
                                                   @if($admin->gender == 'Male') checked @else checked @endif>
                                            <label for="Male" class="custom-control-label">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="Female"
                                                   name="gender" value="Female"
                                                   @if($admin->gender == 'Female') checked @endif>
                                            <label for="Female" class="custom-control-label">Female</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Account Status</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="account_status"
                                                   id="account_status"
                                                   @if($admin->status == 'Active') checked @endif>
                                            <label class="custom-control-label" for="account_status">Active</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                <button type="button" onclick="updateAdmin('{{$admin->id}}')" class="btn btn-primary">Save</button>
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
        function updateAdmin(id){
            axios.put('/cms/admin/admins/'+id, {
                name: document.getElementById("name").value,
                email: document.getElementById("email").value,
                mobile: document.getElementById("mobile").value,
                age: document.getElementById("age").value,
                gender: document.querySelector('input[name="gender"]:checked').value,
                status: document.getElementById("account_status").checked == true ? "Active" : "Blocked",
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

        function clearAndHideErrors(){
            document.getElementById('error_alert').hidden = true
            var errorMessagesUl = document.getElementById("error_messages_ul");
            errorMessagesUl.innerHTML = '';
        }

        function showMessage(data){
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
