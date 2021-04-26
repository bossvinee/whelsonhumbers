<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
      <div class="navbar-logo">
        <a href="index.html">
          <img class="img-fluid" src="png/logo.png" alt="{{ config('app.name', 'Laravel') }}" />
        </a>
        <a class="mobile-menu" id="mobile-collapse" href="#!">
          <i class="feather icon-menu icon-toggle-right"></i>
        </a>
        <a class="mobile-options waves-effect waves-light">
          <i class="feather icon-more-horizontal"></i>
        </a>
      </div>
      <div class="navbar-container container-fluid">
        <ul class="nav-left">
          <li class="header-search">
            <div class="main-search morphsearch-search">
              <div class="input-group">
                <span class="input-group-prepend search-close">
                  <i class="feather icon-x input-group-text"></i>
                </span>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Enter Keyword"
                />
                <span class="input-group-append search-btn">
                  <i class="feather icon-search input-group-text"></i>
                </span>
              </div>
            </div>
          </li>
          <li>
            <a
              href="#!"
              onclick="if (!window.__cfRLUnblockHandlers) return false; javascript:toggleFullScreen()"
              class="waves-effect waves-light"
              data-cf-modified-d8424a08d31b5b8b406fded2-=""
            >
              <i class="full-screen feather icon-maximize"></i>
            </a>
          </li>
        </ul>
        <ul class="nav-right">
            @guest

            @else
                <li class="header-notification">
                    <div class="dropdown-primary dropdown">
                    <div class="dropdown-toggle" data-toggle="dropdown">
                        <i class="feather icon-bell"></i>
                        <span class="badge bg-c-red">10</span>
                    </div>
                    <ul
                        class="show-notification notification-view dropdown-menu"
                        data-dropdown-in="fadeIn"
                        data-dropdown-out="fadeOut"
                    >
                        <li>
                        <h6>Notifications</h6>
                        <label class="label label-danger">New</label>
                        </li>
                        <li>
                        <div class="media">
                            <div class="media-body">
                            <h5 class="notification-user">John Doe</h5>
                            <p class="notification-msg">
                                Lorem ipsum dolor sit amet, consectetuer elit.
                            </p>
                            <span class="notification-time"
                                >30 minutes ago</span
                            >
                            </div>
                        </div>
                        </li>
                    </ul>
                    </div>
                </li>
              <li class="user-profile header-notification">
                <div class="dropdown-primary dropdown">
                  <div class="dropdown-toggle" data-toggle="dropdown">
                    <img
                      src="{{ asset('dash_resource/jpg/avatar-4.jpg') }}"
                      class="img-radius"
                      alt="User-Profile-Image"
                    />
                    <span>{{ Auth::user()->name }}</span>
                    <i class="feather icon-chevron-down"></i>
                  </div>
                  <ul
                    class="show-notification profile-notification dropdown-menu"
                    data-dropdown-in="fadeIn"
                    data-dropdown-out="fadeOut"
                  >
                    <li>
                      <a href="#">
                        <i class="feather icon-user"></i> Profile
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="feather icon-log-out"></i> Logout
                      </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                  </ul>
                </div>
              </li>
            @endguest

        </ul>
      </div>
    </div>
  </nav>