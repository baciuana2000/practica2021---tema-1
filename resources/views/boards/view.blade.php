@extends('layout.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Board view</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('boards.all')}}">Boards</a></li>
                        <li class="breadcrumb-item active">Board</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$board->name}}</h3>
            </div>

            <div class="card-body">
                <select class="custom-select rounded-0" id="changeBoard">
                    @foreach($boards as $selectBoard)
                        <option @if ($selectBoard->id === $board->id) selected="selected" @endif value="{{$selectBoard->id}}">{{$selectBoard->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="card-body">
          
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Assignment</th>
                            <th>Status</th>
                            <th>Date of creation</th>
                        <th style="width: 40px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{$task->id}}</td>
                               
                                <td>
                                {{$task->name}}
                                </td>
                                <td>{{$task->description}}</td>
                                <td>
                                {{$task->assignment}}
                                </td>
                                
                                <td>
                                {{$task->status === \App\Models\Task::STATUS_CREATED ? 'Status created' :($task->status === \App\Models\Task::STATUS_DONE ? 'Status done' : 'Status in progress')}}
                                </td>
                                <td>
                                {{$task->created_at}}
                                </td>
                               <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-primary"
                                                type="button"
                                                data-board="{{json_encode($task)}}"
                                                data-toggle="modal"
                                                data-target="#taskEditModalAjax">
                                            <i class="fas fa-edit"></i></button>
                                        @if($user->role === 1  )  
                                        <button class="btn btn-xs btn-danger"
                                                type="button"
                                                data-board="{{json_encode($task)}}"
                                                data-toggle="modal"
                                                data-target="#taskDeleteModal">
                                            <i class="fas fa-trash"></i></button>
                                            @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
               
            </div>
        </div>
        <!-- /.card -->
             <!-- edit task -->
     
             <div class="modal fade" id="taskEditModalAjax">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit task</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger hidden" id="taskEditAlert"></div>
                        <div id="taskEditName"></div>
                        <div id="taskEditDescription"></div>
                        <input type="hidden"  id="taskEditIdAjax" value="" />
              

                        <div class="form-group">
                            <label for="taskEditName">Name</label>
                            <input id="taskEditNameAjax" type="text" class="form-control"  
                                          aria-describedby="basic-addon1" name="taskEditNameAjax" value="" />
                             <label for="taskEditDescription">Description</label>
                            <input id="taskEditDescriptionAjax" type="text" class="form-control"  
                                          aria-describedby="basic-addon1" name="taskEditDescriptionAjax" value="" />
                                          <label for="taskEditAssignment">Assignment</label>
                                <select class="custom-select rounded-0" name="role" id="taskEditAssignmentAjax">
                                    @foreach($users as $selectUser)
                                    <option  @if ($selectUser->id === $user->id) selected="selected" @endif value="{{$selectUser->id}}">{{$selectUser->name}}</option>
                                 @endforeach
                                </select>

                                <label for="taskEditStatus">Status</label>
                                <select class="custom-select rounded-0" name="role" id="taskEditStatusAjax">
                                    <option value="{{\App\Models\TASK::STATUS_DONE}}">Done</option>
                                    <option value="{{\App\Models\TASK::STATUS_IN_PROGRESS}}">In progress</option>
                                    <option value="{{\App\Models\TASK::STATUS_CREATED}}">Created</option>
                                </select>
                                <label for="taskEditCreated">Created at</label>
                            <input id="taskEditCreatedAjax" type="text" class="form-control"  
                                          aria-describedby="basic-addon1" name="taskEditCreatedAjax" value="" />
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="taskEditButtonAjax">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- end edit task -->

 <!--  delete task -->
        <div class="modal fade" id="taskDeleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete task</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger hidden" id="taskDeleteAlert"></div>
                        <input type="hidden" id="taskDeleteId" value="" />
                        <p>Are you sure you want to delete: <span id="taskDeleteName"></span>?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="taskDeleteButton">Delete</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
 <!-- end delete task -->
    </section>
    <!-- /.content -->
@endsection