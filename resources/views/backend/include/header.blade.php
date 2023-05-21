<div id="global-loader">
   <div class="whirly-loader"> </div>
</div>
<div class="main-wrapper" id="app">
<loader-component></loader-component>
<div class="header">
   <div class="header-left active">
      <router-link  to="/admin/dashboard"  class="nav-link" class="logo">
         <img src="{{ asset('backend/assets/img/logo.png') }}" alt="">
      </router-link>

      <router-link  to="/admin/dashboard"  class="nav-link"  class="logo-small">
         <img src="{{ asset('backend/assets/img/logo-small.png') }}" alt="">
      </router-link >
      
      <a id="toggle_btn" href="javascript:void(0);">
      </a>
   </div>
   <a id="mobile_btn" class="mobile_btn" href="#sidebar">
   <span class="bar-icon">
   <span></span>
   <span></span>
   <span></span>
   </span>
   </a>
   <ul class="nav user-menu">
      <li class="nav-item dropdown has-arrow main-drop">
         <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
         <span class="user-img"><img src="{{ asset('backend/assets/img/profiles/avator1.jpg') }}" alt="">
         <span class="status online"></span></span>
         </a>
         <div class="dropdown-menu menu-drop-user">
            <div class="profilename">
               <div class="profileset">
                  <span class="user-img"><img src="{{ asset('backend/assets/img/profiles/avator1.jpg') }}" alt="">
                  <span class="status online"></span></span>
                  <div class="profilesets">
                     <h6>Khan Rayees</h6>
                  </div>
               </div>
               <hr class="m-0">
               <a class="dropdown-item" href="#!"> <i class="me-2" data-feather="user"></i> My Profile</a>
               <a class="dropdown-item" href="#!"><i class="me-2" data-feather="settings"></i>Settings</a>
               <hr class="m-0">
               <a href="#!" class="dropdown-item logout pb-0" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  <img src="{{ asset('backend/assets/img/icons/log-out.svg') }}" class="me-2" alt="img">Logout
                  <form id="logout-form" action="#!" method="POST">
                     @csrf
                  </form>
               </a>
            </div>
         </div>
      </li>
   </ul>
   <div class="dropdown mobile-user-menu">
      <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
      <div class="dropdown-menu dropdown-menu-right">
      </div>
   </div>
</div>