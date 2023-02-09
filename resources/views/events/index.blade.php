@extends('layouts.app')

@section('content')

<x-alert></x-alert>
<div class="page-breadcrumb bg-white">
    <div class="row align-items-center">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Events</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <div class="d-md-flex">
                <ol class="breadcrumb ms-auto">
                    <li><a href="{{route('home')}}" class="fw-normal">Dashboard</a></li>
                </ol>
                <a href="{{route('event.create')}}" class="btn btn-sm btn-dark  d-none d-md-block pull-right ms-3 hidden-xs hidden-sm waves-effect waves-light text-white">Add</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title"></h3>
                <p class="text-muted">Total : <code>{{$events->count()}}</code></p>
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                      <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#filterModel" style="color:white" class="btn btn-sm btn-primary"><i class="fa fa-filter"></i> {{__('Filters')}}</a>
                    </ol>
                 </div>

                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="dataTable">
                        <thead class="bg-light">
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Satrt Date')}}</th>
                                <th>{{__('End Date')}}</th>
                                <th>{{__('Type')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr>
                                <td>{{$event->name}}</td>
                                <td>{{$event->startevent}}</td>
                                <td>{{$event->endevent}}</td>
                                <td>{{$event->recurrence_type}}</td>
                                <td>
                                    <a href="{{route('event.edit',$event->id)}}" class="btn btn-sm btn-info"><i
                                            class="fa fa-edit text-white"></i></a>
                                    <a href="javascript:void(0);"
                                        onclick="show('{{csrf_token()}}','{{route('event.show',$event->id)}}')"
                                        class="btn btn-sm btn-warning"><i class="fa fa-eye text-white"></i></a>
                                    <a href="javascript:void(0);" onclick="trash('{{$event->id}}')"
                                        class="btn btn-sm btn-danger"><i class="fa fa-trash text-white"></i></a>
                                    <form method="POST" id="delete_form_{{$event->id}}"
                                        action="{{route('event.destroy',$event->id)}}" accept-charset="UTF-8">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right p-2">
                    {!! $events->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->

<div class="modal fade" id="filterModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="get">
                <div class="modal-header py-1 bg-dark text-white">
                    <h5 class="modal-title">{{__('Apply Filters')}}</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="bookingrecurrence_type_status" class="col-4 control-label">{{__('Recurrence Type')}}</label>
                        <div class="col-8">
                        <select class="form-control single-select" name="recurrence_type">
                        <option value="" selected>{{__('Select')}}</option>
                        <option value="Single">Single</option>
                        <option value="Daily">Daily</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Yearly">Yearly</option>

                       </select>
                    </div>
                   </div>
                </div>
                <div class="modal-footer p-1">
                    <button type="submit" class="btn btn-sm btn-primary">{{__('Apply')}}</button>
                    <a href="{{route('event.list')}}" class="btn btn-sm btn-secondary" >{{__('Clear All')}}</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

