@if (session('success'))
   <div class="alert alert-success alert-dismissable fad show">
       <button class="close" data-dismiss="alert" aria-label="Close">x</button>
       {{session('success')}}

   </div>
    
    
@endif
@if (session('error'))
   <div class="alert alert-danger alert-dismissable fad show">
       <button class="close" data-dismiss="alert" aria-label="Close">x</button>
       {{session('error')}}

   </div>
    
    
@endif