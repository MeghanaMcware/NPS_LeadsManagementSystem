<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="#" class="d-flex flex-row align-items-center gap-2">
                <img class="img-fluid for-light" src="{{ asset('admin/assets/images/logo/NPS_logo (1).png') }}" alt="">
                <img class="img-fluid for-dark" src="{{ asset('admin/assets/images/GBA-removebg-preview.png') }}"
                    alt="">
                <span class="fw-bold fs-6 text-white">NPS Admin</span>
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow">
                <i data-feather="arrow-left"></i>
            </div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="">
                            <img class="img-fluid" src="{{ asset('admin/assets/images/logo/NPS_logo (1).png') }}"
                                alt="">
                        </a>
                        <div class="mobile-back text-end">
                            <span>Back</span>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link link-nav {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link link-nav {{ request()->is('leads/*') ? 'active' : '' }}" href="{{ url('/leads/index') }}">
                            <i class="bi bi-person-lines-fill"></i>
                            <span>Leads</span>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link link-nav {{ request()->is('leadsimport/*') ? 'active' : '' }}" href="{{ url('/leadsimport/index') }}">
                            <i class="bi bi-person-plus-fill"></i>
                            <span>Add / Import</span>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link link-nav {{ request()->is('sendmessage/*') ? 'active' : '' }}" href="{{ url('/sendmessage/index') }}">
                            <i class="bi bi-chat-dots-fill"></i>
                            <span>Send Message</span>
                        </a>
                    </li>


            </div>
            <div class="right-arrow" id="right-arrow">
                <i data-feather="arrow-right"></i>
            </div>
        </nav>
    </div>
</div>


<style>
.simplebar-mask {
    top: 72px !important;
}

.simplebar-mask {
    background: #021b45 !important;
}

.simplebar-content {
    margin-top: 15px !important;
}

.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links li a span {
    color: #000;
}

.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content>li a {
    color: #fff;
}

.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content>li .sidebar-link:hover {
    background: #008d54 !important;
    color: #fff !important;
}

.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content>li .sidebar-link:not(.active) span:hover {
    color: #fff !important;
}


.sidebar-link.active {
    background: #008d54 !important;
    color: #fff !important;
    border-radius: 8px;
    /* optional for better look */
}

/* Keep the icon white when the link is active. */
.sidebar-link.active i {
    color: #fff !important;
}

/* Active state overrides for text and span */
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links li a.sidebar-link.active span {
    color: #fff !important;
}

.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content>li a.sidebar-link.active {
    color: #fff !important;
}

.page-wrapper.compact-wrapper .page-body-wrapper .page-body {
    background: #f6fdff94 !important;
}

.logo-wrapper {
    background: #021b45 !important;
}

.header-wrapper {
    background: #fff !important;
}

.page-wrapper .page-header .header-wrapper {
    padding: 19px 30px !important;
    background: #fff !important;
}

.sidebar-list .sidebar-link.active {
    background: #62667a !important;
    color: #fff !important;
}

.sidebar-list .sidebar-link.active1 {
    background: #ededed !important;
    color: #000 !important;
}

.sidebar-list .sidebar-link.active span,
.sidebar-list .sidebar-link.active i {
    color: #fff !important;
}

.sidebar-list .sidebar-link.active1 i {
    color: #000 !important;
}

.sidebar-list .sidebar-link.active1 span {
    color: #000 !important;
}

.page-wrapper.compact-wrapper .page-body-wrapper .according-menu i {
    color: #000 !important;
}
</style>