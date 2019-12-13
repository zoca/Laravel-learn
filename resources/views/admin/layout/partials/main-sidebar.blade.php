 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
         <div class="sidebar-brand-icon rotate-n-15">
             <i class="fas fa-laugh-wink"></i>
         </div>
         <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <!-- <li class="nav-item">
         <a class="nav-link" href="index.html">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>{{ __('users.dashboard') }}</span></a>
     </li> -->

     <!-- Divider -->
     <!-- <hr class="sidebar-divider"> -->

     <!-- Heading -->
     <!-- <div class="sidebar-heading">
         {{ __('users.interface') }}
     </div> -->

     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-fw fa-file"></i>
             <span>{{ __('users.pages') }}</span>
         </a>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="{{ route('pages.index') }}">{{ __('users.preview-all') }}</a>
                 <a class="collapse-item" href="{{ route('pages.create') }}">{{ __('users.add-new') }}</a>
             </div>
         </div>
     </li>

     <!-- Nav Item - Utilities Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
             <i class="fas fa-fw fa-user"></i>
             <span>{{ __('users.users') }}</span>
         </a>
         <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="{{ route('users.index') }}">{{ __('users.preview-all') }}</a>
                 <a class="collapse-item" href="{{ route('users.create') }}">{{ __('users.add-new') }}</a>
             </div>
         </div>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <!-- <div class="sidebar-heading">
         {{ __('users.addons') }}
     </div> -->

     <!-- Nav Item - Pages Collapse Menu -->
     <!-- <li class="nav-item active">
         <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
             <i class="fas fa-fw fa-folder"></i>
             <span>{{ __('users.pages') }}</span>
         </a>
         <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">{{ __('users.login-screens') }}</h6>
                 <a class="collapse-item" href="login.html">{{ __('users.login') }}</a>
                 <a class="collapse-item" href="register.html">{{ __('users.register') }}</a>
                 <a class="collapse-item" href="forgot-password.html">{{ __('users.forgot-password') }}</a>
                 <div class="collapse-divider"></div>
                 <h6 class="collapse-header">{{ __('users.other-pages') }}</h6>
                 <a class="collapse-item" href="404.html">{{ __('users.404') }}</a>
                 <a class="collapse-item active" href="blank.html">{{ __('users.blank-page') }}</a>
             </div>
         </div>
     </li> -->

     <!-- Nav Item - Charts -->
     <!-- <li class="nav-item">
         <a class="nav-link" href="charts.html">
             <i class="fas fa-fw fa-chart-area"></i>
             <span>{{ __('users.charts') }}</span></a>
     </li> -->

     <!-- Nav Item - Tables -->
     <!-- <li class="nav-item">
         <a class="nav-link" href="tables.html">
             <i class="fas fa-fw fa-table"></i>
             <span>{{ __('users.charts') }}</span></a>
     </li> -->

     <!-- Divider -->
     <!-- <hr class="sidebar-divider d-none d-md-block"> -->

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>

 </ul>
 <!-- End of Sidebar -->