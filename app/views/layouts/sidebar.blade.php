<aside id="sidebar" class="sidebar c-overflow">
    <div class="profile-menu">
        <a href="{{ URL::to('user/profile') }}">
            <div class="profile-pic">
                @if(Session::get('user')->picture != '')
                <img src="{{ Config::get('app.service_config.domain') }}/index.php?entryPoint=getAvatar&id={{Session::get('user')->picture}}&type=SugarFieldImage&isTempFile=1" alt="">
                @else
                <img src="{{ URL::asset('public/img/customer-avatar.png') }}" alt="">
                @endif
            </div>

            <div class="profile-info">
                {{ Session::get('user')->last_name }} {{ Session::get('user')->first_name }} ({{ Session::get('user')->user_name }})

                <i class="zmdi zmdi-caret-down"></i>
            </div>
        </a>

        <ul class="main-menu"> 
            <li>
                <a id="menu-change-password" href="{{ URL::to('user/changePassword') }}"><i class="zmdi zmdi-lock"></i> {{ trans('app.change_password') }}</a>
            </li>
            <li>
                <a id="menu-logout" href="{{ URL::to('user/logout') }}"><i class="zmdi zmdi-lock-open"></i> {{ trans('app.logout') }}</a>
            </li>
        </ul>
    </div>

    <ul class="main-menu">   
        <li class="sub-menu @if (Request::is('customer/*')) active @endif">
            <a href="#"><i class="zmdi zmdi-account"></i> {{ trans('app.customer') }}</a>
            <ul>
                <li><a href="{{ URL::to('/customer/edit') }}"><i class="zmdi zmdi-plus"></i> {{ trans('app.create') }}</a></li>
                <li><a href="{{ URL::to('/customer/index') }}"><i class="zmdi zmdi-view-list"></i> {{ trans('app.customer_listview') }}</a></li>
            </ul>
        </li> 
        <li class="sub-menu @if (Request::is('payment/*')) active @endif">
            <a href="#"><i   class="zmdi zmdi-card"></i> {{ trans('app.payment') }}</a>
            <ul>
                <li><a href="{{ URL::to('/payment/edit') }}"><i class="zmdi zmdi-plus"></i> {{ trans('app.create') }}</a></li>
                <li><a href="{{ URL::to('/payment/index') }}"><i class="zmdi zmdi-view-list"></i> {{ trans('app.listview') }}</a></li>
            </ul>
        </li> 
        <li class="sub-menu @if (Request::is('product/*')) active @endif">
            <a href="#"><i   class="zmdi zmdi-folder-star"></i> {{ trans('app.product') }}</a>
            <ul>
                <li><a href="{{ URL::to('/product/edit') }}"><i class="zmdi zmdi-plus"></i> {{ trans('app.create') }}</a></li>
                <li><a href="{{ URL::to('/product/index') }}"><i class="zmdi zmdi-view-list"></i> {{ trans('app.listview') }}</a></li>
            </ul>
        </li> 
    </ul>
</aside>