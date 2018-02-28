{!! Form::open([ 'url'=> '/admin/new_index_page_element',  'method'=> 'post' , 'id' => 'new_element_'.$type]) !!}
{!! Form::hidden('type' , isset($type) ? $type : '') !!}
{!! Form::submit('Új', ['class' => 'btn green-meadow btn-block']) !!}
{!! Form::close() !!}