<input type="hidden" name="content_controller" value="{{$item->content_controller or ''}}">
<input type="hidden" name="title" value="{{$item->title or ''}}">
<input type="hidden" name="slug" value="{{$item->slug or ''}}">
<input type="hidden" name="related_id" value="{{$item->id or ''}}">
<input type="hidden" name="menu_id" value="{{$menu_id or ''}}">
<input type="hidden" name="html_id" value="{{$html_id_prefix or ''}}_{{$item->slug or ''}} '###'{{$item->id or ''}}">
<input type="hidden" name="_token" value="{{csrf_token()}}">