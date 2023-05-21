<div class="sidebar" id="sidebar">
   <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
         <ul>
         <li >
            <router-link  to="/admin/dashboard" active-class="active" class="logo">
            <img src="{{ asset('backend/assets/img/icons/dashboard.svg') }}" alt="img"><span> Dashboard</span> 
            </router-link>
         </li>
         <li>
            <router-link to="/admin/appointments" :class="$route.path.startsWith('/admin/appointments') ? 'active' : ''" class="logo">
            <img src="{{ asset('backend/assets/img/icons/product.svg') }}" alt="img"><span> Appointment</span> 
            </router-link>
         </li>
         
         <li>
            <router-link  to="/admin/users" active-class="active">
            <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img"><span> Users Management</span> 
            </router-link>
         </li>
       
         <li>
            <router-link  to="/admin/settings" active-class="active">
            <img src="{{ asset('backend/assets/img/icons/settings.svg') }}" alt="img"><span>Settings</span> 
            </router-link>
         </li>
         <li>
            <router-link  to="/admin/profile" active-class="active">
            <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img"><span>Profile</span> 
            </router-link>
         </li>
         <li>
            <a  href="javascript:void(0)">
            <img src="{{ asset('backend/assets/img/icons/time.svg') }}" alt="img"><span>Logout</span> 
            </a>
         </li>
      </div>
   </div>
</div>