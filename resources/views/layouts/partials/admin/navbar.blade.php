          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="bx bx-menu bx-md"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <!-- Search -->
              <div class="navbar-nav align-items-center me-auto">
                <form class="nav-item d-flex align-items-center" method="GET" action="{{ url()->current() }}">
                  <button type="submit" class="btn btn-link p-0 me-2 text-secondary" aria-label="Search">
                    <i class="icon-base bx bx-search icon-md"></i>
                  </button>
                  <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    class="form-control border-0 shadow-none ps-1 ps-sm-2 d-md-block d-none"
                    placeholder="Search..."
                    aria-label="Search..." />
                </form>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow p-0"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      @auth
                        <img src="{{ auth()->user()->profile_url ?? asset('assets/img/logo/ngawi.png') }}" alt="{{ auth()->user()->name }}" style="width:40px;height:40px;object-fit:cover;object-position:center;border-radius:50%;" />
                      @else
                        <img src="{{ asset('assets/img/logo/ngawi.png') }}" alt class="" style="width:40px;height:40px;object-fit:cover;object-position:center;border-radius:50%;" />
                      @endauth
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      @auth
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar avatar-online">
                                <img src="{{ auth()->user()->profile_url ?? asset('assets/img/logo/ngawi.png') }}" alt="{{ auth()->user()->name }}" style="width:40px;height:40px;object-fit:cover;object-position:center;border-radius:50%;" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                               <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                          </div>
                        </a>
                      @else
                        <a class="dropdown-item" href="#">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar avatar-online">
                                <img src="{{ asset('assets/img/logo/ngawi.png') }}" alt class="" style="width:40px;height:40px;object-fit:cover;object-position:center;border-radius:50%;" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-0">Desa Jenangan</h6>
                              <small class="text-muted">Admin</small>
                            </div>
                          </div>
                        </a>
                      @endauth
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bx bx-user bx-md me-3"></i><span>My Profile</span>
                      </a>
                    </li>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                      <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->
