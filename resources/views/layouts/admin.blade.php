<!doctype html>

<html
  lang="en"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
  data-style="light">
  <head>
  @include('layouts.partials.admin.header')
  </head>

  <body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
  @include('layouts.partials.admin.sidebar')
        <div class="layout-page">
          @include('layouts.partials.admin.navbar')
          <div class="content-wrapper">
            @yield('content')
            @include('layouts.partials.admin.footer')
            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
  @include('layouts.partials.admin.scripts')
</body>
</html>
