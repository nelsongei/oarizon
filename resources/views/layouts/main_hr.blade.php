@include('includes.head')
<body>

<div class="loader-bg">
    <div class="loader-bar"></div>
</div>
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        @include('includes.top_nav')
        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                @include('includes.nav_css_admin')
                <div class="pcoded-content">
                    @yield('xara_cbs')
                </div>
                <div id="styleSelector">
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@include('includes.foot')

