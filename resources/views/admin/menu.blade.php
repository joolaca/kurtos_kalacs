<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->

    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->

            <li class="heading">
                <h3 class="uppercase">TARTALOMKEZELÉS</h3>
            </li>
            <li class="nav-item start open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-book-open"></i>
                    <span class="title">Oldalak</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu always-open">

                    <li class="nav-item start ">
                        <a href="{{url('/admin/content')}}" class="nav-link ">
                            <i class="icon-list"></i>
                            <span class="title">Tartalom</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{url('/admin/index_page')}}" class="nav-link ">
                            <i class="icon-home"></i>
                            <span class="title">Index oldal</span>
                        </a>
                    </li>

                    <li class="nav-item start ">
                        <a href="{{url('/admin/menu_category')}}" class="nav-link new_content_type_view" data-href="http://budweb-cms.local/articles/modal/create_modal_view">
                            <i class="icon-plus"></i>
                            <span class="title">Menü</span>
                        </a>
                    </li>


                </ul>
            </li>

            <li class="nav-item start">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-picture"></i>
                    <span class="title">Képek</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu always-open">


                    <li class="nav-item start ">
                        <a href="{{url('/admin/slides')}}" class="nav-link ">
                            <i class="icon-list"></i>
                            <span class="title">Képek  listája</span>
                        </a>
                    </li>

                    <li class="nav-item start ">
                        <a href="{{url('/admin/slides/create')}}" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">Új kép felvétele</span>
                        </a>
                    </li>


                    <li class="nav-item start ">
                        <a href="{{url('/admin/categories/slide')}}" class="nav-link ">
                            <i class="icon-folder-alt"></i>
                            <span class="title">Kép kategóriák</span>
                        </a>
                    </li>

                    <li class="nav-item start ">
                        <a href="{{url('/admin/thumbnail')}}" class="nav-link ">
                            <i class="icon-grid"></i>
                            <span class="title">Képméretek</span>
                        </a>
                    </li>


                    <li class="nav-item start ">
                        <a href="{{url('/admin/slides/multiple_upload')}}" class="nav-link ">
                            <i class="icon-cloud-upload"></i>
                            <span class="title">Tömeges képfeltöltés</span>
                        </a>
                    </li>


                </ul>
            </li>

            <li class="nav-item start ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-grid"></i>
                    <span class="title">Képgalériák</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu always-open">

                    <li class="nav-item start ">
                        <a href="{{url('/admin/galleries')}}" class="nav-link ">
                            <i class="icon-list"></i>
                            <span class="title">Képgalériák</span>
                        </a>
                    </li>

                    <li class="nav-item start ">
                        <a href="{{url('/admin/galleries/create')}}" class="nav-link new_content_type_view" data-href="http://budweb-cms.local/galleries/modal/create_modal_view">
                            <i class="icon-plus"></i>
                            <span class="title">Új Képgaléria</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item start ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">Rendszer</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu always-open">

                    <li class="nav-item start ">
                        <a href="{{url('/admin/translations')}}" class="nav-link ">
                            <i class="icon-layers"></i>
                            <span class="title">Fordítás</span>
                        </a>
                    </li>
                </ul>
            </li>




        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>