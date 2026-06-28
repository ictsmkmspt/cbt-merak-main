<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ ('img/favicon.ico') }}">
    <title>CBT - Merak Computer Based Test Web App</title>

    <!-- <link href="{!! url('vendor/twbs/bootstrap/dist/css/bootstrap.min.css') !!}" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
    <link href="{!! url('css/login.css') !!}" rel="stylesheet">

  <!-- mdl -->
    <link rel="stylesheet" href="{{ url('/assets/mdl/material.min.css') }}">
    <script src="{{ url('/assets/mdl/material.min.js') }}"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{ url('/css/mdl-styles.css') }}">
    <style>
      #view-source {
        position: fixed;
        display: block;
        right: 0;
        bottom: 0;
        margin-right: 40px;
        margin-bottom: 40px;
        z-index: 900;
      }
    </style>
  </head>
  <body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <div class="android-header mdl-layout__header mdl-layout__header--waterfall">
        <div class="mdl-layout__header-row">
          <span class="android-title mdl-layout-title mdl-typography--text-uppercase" style="font-size:22px; font-weight:600; color:#77c259;">
            {{ $namasekolah }}
          </span>
          <div class="android-header-spacer mdl-layout-spacer"></div>
          <div class="android-search-box mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right mdl-textfield--full-width">
            <label class="mdl-button mdl-js-button mdl-button--icon" for="search-field">
              <i class="material-icons">search</i>
            </label>
            <div class="mdl-textfield__expandable-holder">
              <input class="mdl-textfield__input" type="text" id="search-field">
            </div>
          </div>
          <div class="android-navigation-container">
            <nav class="android-navigation mdl-navigation">
              <a class="mdl-navigation__link mdl-typography--text-uppercase" href="/">Beranda</a>
              <a class="mdl-navigation__link mdl-typography--text-uppercase" href="#">Profil</a>
              <a class="mdl-navigation__link mdl-typography--text-uppercase" href="{{ url('guru') }}"><i class="material-icons">vpn_key</i> Guru</a>
              <a class="mdl-navigation__link mdl-typography--text-uppercase" href="{{ url('lobby-siswa') }}"><i class="material-icons">vpn_key</i> Siswa</a>
            </nav>
          </div>
          <span class="android-mobile-title mdl-layout-title" 
            style="font-weight:600; color:#77c259; top:18px;">
            SMKM SAMPIT
          </span>
          <button class="android-more-button mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect" id="more-button">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right mdl-js-ripple-effect" for="more-button">
            <li class="mdl-menu__item">Contact</li>
            <li class="mdl-menu__item">About</li>
          </ul>
        </div>
      </div>
      <div class="android-drawer mdl-layout__drawer">
        <span class="mdl-layout-title">
          <img class="android-logo-image" src="">
        </span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="">Beranda</a>
          <a class="mdl-navigation__link" href="">Profil</a>
          <a class="mdl-navigation__link" href="">Program Keahlian</a>
          <div class="android-drawer-separator"></div>
          <a class="mdl-navigation__link" href="{{ url('guru') }}">CBT Login Guru</a>
          <a class="mdl-navigation__link" href="{{ url('lobby-siswa') }}">CBT Login Siswa</a>
          <div class="android-drawer-separator"></div>
          <a class="mdl-navigation__link" href="">About</a>
          <span class="mdl-navigation__link" href="">Contact</span>
        </nav>
      </div>
      
      @yield('content')

      <footer class="android-footer mdl-mega-footer">
        <div class="mdl-mega-footer--top-section">
          <div class="mdl-mega-footer--right-section">
            <a class="mdl-typography--font-light" href="#top">
              Kembali ke atas
              <i class="material-icons">expand_less</i>
            </a>
          </div>
        </div>
      </footer>
    </div>
	
    
  <script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
  <script src="{{ url('lib/bootstrap/js/bootstrap.js') }}"></script>
  <script src="{{ url('/js/jquery.backstretch.min.js') }}"></script>
  <script>
    // $.backstretch("{{ url('/img/bg_merak02.jpg') }}", {speed: 150});
    
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  </script>

  <!-- [FIXED: iPhone login issued] -->
  <!-- Modal -->
  <div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <br>
          <div class="bs-example bs-example-tabs">
              <ul id="myTab" class="nav nav-tabs">
                <li class="active"><a href="#signin" data-toggle="tab">Sign In</a></li>
                <li class=""><a href="#why" data-toggle="tab">About?</a></li>
              </ul>
          </div>
        <div class="modal-body">
          <div id="myTabContent" class="tab-content">
          <div class="tab-pane fade in" id="why">
          <p>Aplikasi ujian ini di kembangkan dengan desain responsive, sehingga bisa diakses dengan baik terhadap berbagai perangkat (Laptop, Tab atau Smartphone).</p>
          <p>Jika mengalami kendala dalam pengoperasian aplikasi ini, silahkan hubungi ke Club TKJ SMK Muhammadiyah Sampit untuk mendapatkan bantuan teknis.</p>
          </div>
          <div class="tab-pane fade active in" id="signin">
              <form method="POST" action="{{ url('/auth/login') }}">
              {!! csrf_field() !!}
              <fieldset>
              <div class="control-group">
                <label class="control-label" for="userid">Email:</label>
                <div class="controls">
                  <input type="email" name="email" class="form-control" value="" placeholder="Email">
                </div>
              </div>

              <!-- Password input-->
              <div class="control-group">
                <label class="control-label" for="passwordinput">Password:</label>
                <div class="controls">
                  <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>
              </div>

              <!-- Multiple Checkboxes (inline) -->
              <div class="control-group">
                <label class="control-label" for="rememberme">&nbsp;</label>
                <div class="controls">
                  <label class="checkbox inline" for="rememberme-0">
                    <input type="checkbox" name="remember" id="remember" value="Remember me" style="margin: 0 0 0 0;">
                    <span style="margin: 0 0 0 25px;">Remember me</span>
                  </label>
                </div>
              </div>

              <!-- Button -->
              <div class="control-group">
                <label class="control-label" for="signin"></label>
                <div class="controls">
                  <button id="signin" name="signin" class="btn btn-success">Login</button>
                  <button type="submit" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
              </div>
              </fieldset>
              </form>
          </div>
      </div>
        </div>
        
      </div>
    </div>
  </div>

  </body>
</html>
