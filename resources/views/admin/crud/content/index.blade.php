@extends('admin.layouts.admin_layout')
@section('content')
<h1 class="page-title"></h1>
<div class="row">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <div class="caption-subject font-dark sbold uppercase">
                    Kereső
                </div>
            </div>
        </div> {{--portlet-title--}}
        <div class="portlet-body form">
            <form action="" class="form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Block Help</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Enter text">
                            <span class="help-block"> A block of help text. </span>
                        </div>
                    </div>
                </div> {{--end form-body--}}

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">Submit</button>
                            <button type="button" class="btn default">Cancel</button>
                        </div>
                    </div>
                </div> {{--end form-actions--}}

            </form>
        </div> {{--portlet-body--}}
    </div>
</div> {{--end search--}}

<div class="row">

    <div class="btn-group">
        <a href="{{url('/admin/content/create')}}" type="button" class="btn green-meadow">Új tartalom <i class="fa fa-plus"></i> </a>
    </div>
</div>

<div class="row">
    <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer">
        <thead>
            <th>Cím</th>
            <th>Nyelv</th>
            <th>&nbsp;</th>
        </thead>

        <tbody>
            @foreach($contents as $content)
                <tr>
                    <td>{{$content->title}}</td>
                    <td>{{$content->lang}}</td>
                    <td>
                        <a href="{{url("/admin/content/$content->id/edit")}}" type="button" class="btn btn-primary">Szerkesztés</a>
                        <a type="button" class="btn btn-danger">Törlés</a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>


@endsection