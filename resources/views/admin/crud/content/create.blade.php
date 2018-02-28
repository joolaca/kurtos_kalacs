@extends('admin.layouts.admin_layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Form Sample </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                        <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
                        <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
                        <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['route' => 'content.store', 'role' => 'form',]) !!}

                        <div class="form-body">

                            <div class="form-group @if($errors->has('title')) has-error @endif">
                                <label class="control-label col-md-3">Cím</label>
                                <div class="col-md-9">
                                    {{Form::text('title', '', ['class'=>'form-control'])}}
                                    @if ($errors->has('title'))
                                        <span class="help-block">{{$errors->first('title')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nyelve</label>
                                <div class="col-md-9">
                                    {{Form::select('lang',\App\Model\Lang::all()->pluck('title', 'lang') ,'', ['class'=>'form-control'])}}

                                </div>
                            </div>

                        </div> {{--form-body--}}

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn green">
                                                <i class="fa fa-check"></i> Submit</button>
                                            <button type="button" class="btn default">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
@endsection