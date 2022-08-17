 <div class="kt-portlet__head">

     <div class="kt-portlet__head-toolbar">

         <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-brand nav-tabs-line-2x nav-tabs-line-right nav-tabs-bold" role="tablist">
             <li class="nav-item">
                 <a class="nav-link {{ request()->routeIs('admin.users.show') ?  'active' : '' }}" href="{{ route('admin.users.show', $user) }}" role="tab" aria-selected="{{ request()->routeIs('admin.users.show') ? 'true' : 'false' }}">
                     <i class="flaticon2-heart-rate-monitor" aria-hidden="true"></i>
                     Profile
                 </a>

             </li>

             <li class="nav-item">
                 <a class="nav-link {{ request()->routeIs('admin.users.orders') ?  'active' : '' }}" href="{{ route('admin.users.orders', $user) }}" role="tab" aria-selected="{{ request()->routeIs('admin.users.show') ? 'true' : 'false' }}">
                     Orders
                 </a>

             </li>

             <li class="nav-item">
                 <a class="nav-link {{ request()->routeIs('admin.users.referrals') ?  'active' : '' }}" href="{{ route('admin.users.referrals', $user) }}" role="tab" aria-selected="{{ request()->routeIs('admin.users.show') ? 'true' : 'false' }}">
                     Referrals
                 </a>

             </li>

             <li class="nav-item">
                 <a class="nav-link {{ request()->routeIs('admin.users.reviews') ?  'active' : '' }}" href="{{ route('admin.users.reviews', $user) }}" role="tab" aria-selected="{{ request()->routeIs('admin.users.show') ? 'true' : 'false' }}">
                     Reviews
                 </a>

             </li>

             {{-- <li class="nav-item">
                 <a class="nav-link {{ request()->routeIs('admin.users.promos') ?  'active' : '' }}" href="{{ route('admin.users.promos', $user) }}" role="tab" aria-selected="{{ request()->routeIs('admin.users.show') ? 'true' : 'false' }}">
                     Promo
                 </a>
--}}
             </li>

             <li class="nav-item">
                 <a class="nav-link {{ request()->routeIs('admin.users.rewards') ?  'active' : '' }}" href="{{ route('admin.users.rewards', $user) }}" role="tab" aria-selected="{{ request()->routeIs('admin.users.show') ? 'true' : 'false' }}">
                     Rewards
                 </a>

             </li>
         </ul>

     </div>

 </div>
