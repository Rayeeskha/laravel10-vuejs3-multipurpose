@include('backend.include.css')
@include('backend.include.header')
@include('backend.include.sidebar')

<div class="page-wrapper" >
    <div class="content">               
        <router-view></router-view>                            
    </div>
 </div>
</div>

@include('backend.include.js')