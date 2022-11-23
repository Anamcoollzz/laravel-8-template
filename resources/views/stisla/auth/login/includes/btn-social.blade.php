@if ($_is_login_with_google || $_is_login_with_facebook || $_is_login_with_twitter || $_is_login_with_github)
  <div class="text-center mt-4 mb-3">
    <div class="text-job text-muted">Atau Masuk Dengan</div>
  </div>

  <div class="row">
    <div class="col-md-12" align="center">
      @if ($_is_login_with_google)
        <a href="{{ route('social-login', ['google']) }}" class="btn btn-social-icon btn-facebook mr-1" style="background-color: rgba(220,20,20,1)">
          <i class="fab fa-google"></i>
        </a>
      @endif
      @if ($_is_login_with_facebook)
        <a href="{{ route('social-login', ['facebook']) }}" class="btn btn-social-icon btn-facebook mr-1">
          <i class="fab fa-facebook-f"></i>
        </a>
      @endif
      @if ($_is_login_with_twitter)
        <a href="{{ route('social-login', ['twitter']) }}" class="btn btn-social-icon btn-twitter mr-1">
          <i class="fab fa-twitter"></i>
        </a>
      @endif
      @if ($_is_login_with_github)
        <a href="{{ route('social-login', ['github']) }}" class="btn btn-social-icon btn-github mr-1">
          <i class="fab fa-github"></i>
        </a>
      @endif
    </div>
  </div>

  {{-- <div class="row">
          @if ($_is_login_with_google)
            <div class="col-md-6">
              <a class="btn btn-block btn-social btn-facebook" style="background-color: rgba(220,20,20,1)" href="{{ route('social-login', ['google']) }}">
                <span class="fab fa-google"></span> Google
              </a>
            </div>
          @endif

          @if ($_is_login_with_facebook)
            <div class="col-md-6">
              <a class="btn btn-block btn-social btn-facebook" href="{{ route('social-login', ['facebook']) }}">
                <span class="fab fa-facebook"></span> Facebook
              </a>
            </div>
          @endif
          <div class="col-md-6">
            <a class="btn btn-block btn-social btn-twitter" href="{{ route('social-login', ['twitter']) }}">
              <span class="fab fa-twitter"></span> Twitter
            </a>
          </div>
        </div> --}}
@endif
