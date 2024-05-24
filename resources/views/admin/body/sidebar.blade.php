 <div class="vertical-menu">

     <div data-simplebar class="h-100">

         <!-- User details -->


         <!--- Sidemenu -->
         <div id="sidebar-menu">
             <!-- Left Menu Start -->
             <ul class="metismenu list-unstyled" id="side-menu">
                 <li class="menu-title">Menu</li>

                 <li>
                     <a href="{{ route('dashboard') }}" class="waves-effect">
                         <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end"></span>
                         <span>Dashboard</span>
                     </a>
                     <a href="{{ route('dashboard-report') }}" class="waves-effect">
                         <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end"></span>
                         <span>Report</span>
                     </a>
                 </li>


                 @admin
                     <li class="menu-title">Admin</li>

                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class="ri-lock-line"></i>
                             <span>Security</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a href="{{ route('admin.users.index') }}">Accounts</a></li>
                             <li><a href="{{ route('admin.roles.index') }}">Role</a></li>
                             <li><a href="{{ route('admin.permissions.index') }}">Permission</a></li>
                         </ul>
                     </li>

                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class="ri-user-2-line"></i>
                             <span>Administrator</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a href="{{ route('admin.positions.index') }}">Position</a></li>
                             <li><a href="{{ route('admin.departments.index') }}">Departments</a></li>
                             {{-- <li><a href="{{ route('admin.user-profiles.index') }}">User Profile</a></li> --}}
                         </ul>
                     </li>


                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class="ri-account-circle-line"></i>
                             <span>Authentication</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a href="auth-login.html">Login</a></li>
                             <li><a href="auth-register.html">Register</a></li>
                             <li><a href="auth-recoverpw.html">Recover Password</a></li>
                             <li><a href="auth-lock-screen.html">Lock Screen</a></li>
                         </ul>
                     </li>

                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class="ri-user-shared-2-line"></i>
                             <span>Leads</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a href="{{ route('disposition.index') }}">Disposition</a></li>
                             <li><a href="{{ route('classcodes.index') }}">Classcodes</a></li>
                             <li><a href="{{ route('sic.index') }}">Standard Industrial Classifications</a></li>
                             {{-- <li><a href="auth-lock-screen.html">Lock Screen</a></li> --}}
                         </ul>
                     </li>

                     {{-- <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-profile-line"></i>
                                    <span>Utility</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="pages-starter.html">Starter Page</a></li>
                                    <li><a href="pages-timeline.html">Timeline</a></li>
                                    <li><a href="pages-directory.html">Directory</a></li>
                                    <li><a href="pages-invoice.html">Invoice</a></li>
                                    <li><a href="pages-404.html">Error 404</a></li>
                                    <li><a href="pages-500.html">Error 500</a></li>
                                </ul>
                            </li> --}}
                 @endadmin



             </ul>
         </div>
         <!-- Sidebar -->
     </div>
 </div>
