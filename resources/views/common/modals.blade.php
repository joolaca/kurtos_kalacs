<!-- MODALS START -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <iframe frameborder="0" scrolling="no" id="modalframe" data-callback="" data-caller="" width="100%" height="560"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('global.close') }}</button>
            </div>
        </div>
    </div>
</div>

@yield('include_modals')
<!-- MODALS END -->