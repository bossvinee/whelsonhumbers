<nav class="pcoded-navbar">
    <div class="nav-list">
      <div class="pcoded-inner-navbar main-menu">

        <ul class="pcoded-item pcoded-left-item">
          <li class="">
            <a
              href="{{ url('/home') }}"
              class="waves-effect waves-dark"
            >
              <span class="pcoded-micon"
                ><i class="feather icon-home"></i
              ></span>
              <span class="pcoded-mtext">Dashboard</span>
            </a>
          </li>

          <li class="pcoded-hasmenu">
            <a
              href="javascript:void(0)"
              class="waves-effect waves-dark"
            >
              <span class="pcoded-micon"
                ><i class="fa fa-users"></i></span>
              <span class="pcoded-mtext">Users</span>
            </a>
            <ul class="pcoded-submenu">
              <li class="">
                <a
                  href="{{ url('users/create') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Add New</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('users') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Manage Users</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('deleted-users') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Deleted Users</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="pcoded-hasmenu">
            <a
              href="javascript:void(0)"
              class="waves-effect waves-dark"
            >
              <span class="pcoded-micon"
                ><i class="fa fa-th-large"></i
              ></span>
              <span class="pcoded-mtext">Departments</span>
            </a>
            <ul class="pcoded-submenu">
              <li class="">
                <a
                  href="{{ url('departments/create') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Add New</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('departments') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Manage Departments</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="pcoded-hasmenu">
            <a
              href="javascript:void(0)"
              class="waves-effect waves-dark"
            >
              <span class="pcoded-micon"
                ><i class="feather icon-sidebar"></i
              ></span>
              <span class="pcoded-mtext">Employee Types</span>
            </a>
            <ul class="pcoded-submenu">
              <li class="">
                <a
                  href="{{ url('usertypes/create') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Add New</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('usertypes') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Manage Employees</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="pcoded-hasmenu">
            <a
              href="javascript:void(0)"
              class="waves-effect waves-dark"
            >
              <span class="pcoded-micon"
                ><i class="fa fa-tasks"></i></span>
              <span class="pcoded-mtext">Allocations</span>
            </a>
            <ul class="pcoded-submenu">
              <li class="">
                <a
                  href="{{ url('allocations/create') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Add New</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('allocations') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Allocations</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('allocations') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Import Allocation</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('bulk-allocation') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Bulk Allocation</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('bulk-allocation') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Deleted Allocations</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="pcoded-hasmenu">
            <a
              href="javascript:void(0)"
              class="waves-effect waves-dark"
            >
              <span class="pcoded-micon"
                ><i class="feather icon-sidebar"></i
              ></span>
              <span class="pcoded-mtext">Jobcards</span>
            </a>
            <ul class="pcoded-submenu">
              <li class="">
                <a
                  href="{{ url('jobcards/create') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Add New</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('jobcards') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Jobcards</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('jobcards') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Import Jobcards</span>
                </a>
              </li>
              <li class="">
                <a
                  href=""
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Deleted</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="pcoded-hasmenu">
            <a
              href="javascript:void(0)"
              class="waves-effect waves-dark"
            >
              <span class="pcoded-micon"
                ><i class="feather icon-sidebar"></i
              ></span>
              <span class="pcoded-mtext">Food Distribution</span>
            </a>
            <ul class="pcoded-submenu">
              <li class="">
                <a
                  href="{{ url('fdistributions/create') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Add New</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('fdistributions') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Distribution</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('fdistributions') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Import Distribution</span>
                </a>
              </li>
              <li class="">
                <a
                  href="{{ url('fdistributions') }}"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Deleted Distribution</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="pcoded-hasmenu">
            <a
              href="javascript:void(0)"
              class="waves-effect waves-dark"
            >
              <span class="pcoded-micon"
                ><i class="feather icon-sidebar"></i
              ></span>
              <span class="pcoded-mtext">Meet Distribution</span>
            </a>
            <ul class="pcoded-submenu">
              <li class="">
                <a
                  href="menu-bottom.html"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Add New</span>
                </a>
              </li>
              <li class="">
                <a
                  href="menu-bottom.html"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Manage Distribution</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="pcoded-hasmenu">
            <a
              href="javascript:void(0)"
              class="waves-effect waves-dark"
            >
              <span class="pcoded-micon">
                <i class="feather icon-list"></i>
              </span>
              <span class="pcoded-mtext">Collection</span>
            </a>
            <ul class="pcoded-submenu">
              <li class="pcoded-hasmenu">
                <a
                  href="javascript:void(0)"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Food Collection</span>
                </a>
                <ul class="pcoded-submenu">
                  <li class="">
                    <a
                      href="{{ url('/fcollection/create') }}"
                      class="waves-effect waves-dark"
                    >
                      <span class="pcoded-mtext">Add Collection</span>
                    </a>
                  </li>
                  <li class="">
                    <a
                      href="{{ url('/fcollection') }}"
                      class="waves-effect waves-dark"
                    >
                      <span class="pcoded-mtext">Collections</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="pcoded-hasmenu">
                <a
                  href="javascript:void(0)"
                  class="waves-effect waves-dark"
                >
                  <span class="pcoded-mtext">Meet Collection</span>
                </a>
                <ul class="pcoded-submenu">
                  <li class="">
                    <a
                      href="javascript:void(0)"
                      class="waves-effect waves-dark"
                    >
                      <span class="pcoded-mtext">Add Collection</span>
                    </a>
                  </li>
                </ul>
              </li>

            </ul>
          </li>
          <li class="">
            <a
              href="navbar-light.html"
              class="waves-effect waves-dark"
            >
              <span class="pcoded-micon">
                <i class="feather icon-menu"></i>
              </span>
              <span class="pcoded-mtext">Navigation</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
