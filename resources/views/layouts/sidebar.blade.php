<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <!-- <h1 href="#" class="d-block" style = "color: white; text-align: center; font-family: Gabriola"><b>LUGAIT CIMS</b></h1> -->
           <!-- <img src="{{ asset('assets/img/logos/Lugait.png') }}" alt="CIMS LOGO" style = "width: 200px; height: 200px"> -->
          <!-- <h1 href="#" class="d-block" style = "color: white; text-align: center; font-family: Gabriola"><b>LUGAIT CIMS</b></h1> -->
           <img src="{{ asset('assets/img/logos/Lugait.png') }}" alt="CIMS LOGO" style = "width: 200px; height: 200px">

        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2" style = "font-size: 16px">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('managers.dashboard') }}" id = "s_dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                CIMS Dashboard
              </p>
            </a>
          </li>
          @if(Auth::user()->role == 1)
            <li class="nav-item" >  
              <a href="{{ route('deceaseds.forApproval') }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Deceased for Approval
                </p>
              </a>
            </li>
          @endif
          <li class="nav-item" >  
            <a href="{{ route('deceaseds.index') }}" id = "s_deceaseds" class="nav-link">
              <i class="nav-icon fas fa-user-injured"></i>
              <p>
                Manage Deceased
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('services') }}" id = "s_services" class="nav-link">
              <i class="nav-icon fas fa-universal-access"></i>
              <p>
                Services
              </p>
            </a>
          </li>
          <li class="nav-item" >  
            <a href="{{ route('spaceareas.index') }}" id = "s_spaceareas" class="nav-link">
              <i class="nav-icon fas fa-church"></i>
              <p>
                Manage Space Area
              </p>
            </a>
          </li>
          @if(Auth::user()->role == 1)
            <li class="nav-item" >  
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Manage Users
                </p>
              </a>
            </li>
          @endif
          <li class="nav-item" >  
            <a id = "s_logout" type = "button" class="nav-link">
              <i class="nav-icon fas fa-power-off"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
      
    </div>
    <!-- /.sidebar -->
  </aside>

  <script>
  
  </script>