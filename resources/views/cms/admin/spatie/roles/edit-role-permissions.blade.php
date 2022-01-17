@extends('cms.admin.parent')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Roles - {{$role->name}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Roles</li>
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
                            <h3 class="card-title">Notes System - Update Role Permissions</h3>
                            <a href="#" onclick="updateRolePermissions('{{$role->id}}')" class="btn btn-sm btn-info float-right">Update
                                Permissions</a>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <div class="alert alert-danger" id="error_alert" role="alert" hidden>
                                <ul id="error_messages_ul"></ul>
                            </div>
                            <div class="col-md-8">
                                <label>Role: {{$role->name}}</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Guard</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{$permission->id}}</td>
                                        <td><span class="badge badge-info">{{$permission->name}}</span></td>
                                        <td>
                                            <span class="badge badge-primary">
                                                @if($permission->guard_name != '')
                                                    {{$permission->guard_name}}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            @if(count($rolePermissions) == 0)
                                                <div class="form-check">
                                                    <input type="checkbox" name="{{$permission->name}}"
                                                           class="form-check-input" id="{{$permission->id}}">
                                                    {{--                                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>--}}
                                                </div>
                                            @else
                                                <div class="form-check">
                                                    <input type="checkbox" name="{{$permission->name}}"
                                                           class="form-check-input" id="{{$permission->id}}"
                                                           @foreach($rolePermissions as $rolePermission)
                                                           @if($rolePermission->id == $permission->id)
                                                           checked
                                                        @endif
                                                        @endforeach
                                                    >
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Guard</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                            </table>
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
    <!-- Bootstrap Switch -->
    <script src="{{asset('cms/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        var selectedPermissions = [];

        @if(count($rolePermissions) > 0)
        @foreach($rolePermissions as $rolePermission)

        selectedPermissions.push('{{$rolePermission->id}}');

        @endforeach
        @endif

        $('[type="checkbox"]').on('change', function () {
            var isChecked = $(this).is(":checked");
            if (isChecked) {
                selectedPermissions.push($(this).prop('id'));
                console.log('Checked: ' + $(this).prop('name'))
            } else {
                let itemId = $(this).prop('id');
                selectedPermissions = selectedPermissions.filter(function (item) {
                    return item !== itemId;
                });
                console.log('Un-Checked: ' + $(this).prop('name'))
            }
        });

        function updateRolePermissions(id) {
            axios.post('/cms/admin/roles/' + id + '/update-permissions', {
                'permissions': selectedPermissions
            })
                .then(function (response) {
                    // handle success (Status Code: 200)
                    clearAndHideErrors();
                    showMessage(response.data);
                })
                .catch(function (error) {
                    // handle error (Status Code: 400)
                    if (error.response.data.errors !== undefined) {
                        showErrorMessages(error.response.data.errors);
                    } else {
                        showMessage(error.response.data);
                    }
                })
                .then(function () {
                    // always executed
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
            document.getElementById('error_alert').hidden = true;
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
