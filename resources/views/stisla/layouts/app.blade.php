@php
$_meta_description = \App\Models\Setting::where('key', 'meta_description')->first()->value;
$_meta_keywords = \App\Models\Setting::where('key', 'meta_keywords')->first()->value;
$_meta_author = \App\Models\Setting::where('key', 'meta_author')->first()->value;
$_company_name = \App\Models\Setting::where('key', 'company_name')->first()->value;
$_skin = \App\Models\Setting::where('key', 'stisla_skin')->first()->value;
$_app_name = \App\Models\Setting::where('key', 'application_name')->first()->value ?? config('app.name');
$_developer_name = config('app.developer_name');
$_whatsapp_developer = config('developer.whatsapp');
$_year = \App\Models\Setting::where('key', 'year')->first()->value;
$_since = \App\Models\Setting::where('key', 'since')->first()->value;
$_version = \App\Models\Setting::where('key', 'application_version')->first()->value ?? config('app.version');
$_app_name_mobile = \App\Helpers\StringHelper::acronym($_app_name, 2);
$_favicon = \App\Models\Setting::where('key', 'favicon')->first()->value;
$_logo_url = \App\Repositories\SettingRepository::logoUrl();
session(['_meta_description' => $_meta_description, '_meta_keywords' => $_meta_keywords, '_meta_author' => $_meta_author, '_company_name' => $_company_name, '_skin' => $_skin, '_app_name' => $_app_name, '_developer_name' => $_developer_name, '_whatsapp_developer' => $_whatsapp_developer, '_year' => $_year, '_version' => $_version, '_app_name_mobile' => $_app_name_mobile, '_favicon' => $_favicon, '_logo_url' => $_logo_url]);
@endphp

<!DOCTYPE html>
<html lang="en">

<head>

  @include('stisla.includes.meta-title')
  @include('stisla.includes.css')

</head>
@php
$_sidebar_mini = \App\Models\Setting::where('key', 'stisla_sidebar_mini')->first()->value ?? 0;
@endphp

<body class="{{ $_sidebar_mini == 1 ? 'sidebar-mini' : '' }}">
  <div id="app">
    <div class="main-wrapper">
      @include('stisla.includes.navbar')
      @include('stisla.includes.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          @yield('content')
        </section>
      </div>
      @include('stisla.includes.footer')
    </div>
  </div>

  @include('stisla.includes.js')

</body>

</html>
