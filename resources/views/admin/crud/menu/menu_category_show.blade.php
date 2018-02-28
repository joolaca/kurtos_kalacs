@extends('admin.layouts.admin_layout')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">

            <div class="portlet light">
                <div class="portlet-title">
                    Menüi
                </div>

                <div class="portlet-body">

                    <div class="table-scrollable">
                        <table class="table table-hover sort_table" >
                            <thead>
                                <th>Megjelenő szöveg</th>
                                <th>Nyelv</th>
                                <th>&nbsp;</th>
                            </thead>

                            <tbody>
                            @foreach($menus as $menu)
                            <tr>
                                <td>{!! $menu->title !!}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ url('/admin/menu/'.$menu->id.'/edit') }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                    <a href="{!! url('/admin/menu/'.$menu->id.'/delete') !!}">
                                        {{ trans('global.delete') }}
                                    </a>

                                </td>
                            </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection