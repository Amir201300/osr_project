<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User Profile-->
                    <div class="user-profile dropdown m-t-20">
                        <div class="user-pic">

                            <img src="{{ App\Models\basic\Basic::getImage() }}" alt="users" class="rounded-circle img-fluid" />

                        </div>
                        <div class="user-content hide-menu m-t-10">
                            <h5 class="nameOfUser m-b-10 user-name font-medium">{{ Auth::guard('Admin')->user()->name }}</h5>
                            <a href="javascript:void(0)" class="btn btn-circle btn-sm m-r-5" id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="ti-settings"></i>
                            </a>
                            <a href="javascript:void(0)" title="Logout" class="btn btn-circle btn-sm">
                                <i class="ti-power-off"></i>
                            </a>
                            <div class="dropdown-menu animated flipInY" aria-labelledby="Userdd">
                                <a class="dropdown-item" href="{{route('profile.index')}}">
                                    <a class="dropdown-item" href="{{route('user.logout')}}">
                                        <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                    <!-- End User Profile-->
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="/manage/home" aria-expanded="false">
                        <i class="fa fa-home"></i>
                        <span class="hide-menu">{{trans('main.home')}}</span>
                    </a>
                </li>
                <!-- User Profile-->
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">الروابط الرئيسة</span>
                </li>
                {{-- USers --}}
                {{-- settings --}}
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-Mailbox-Empty"></i>
                        <span class="hide-menu">الاعدادات الرئيسية </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">

                        <li class="sidebar-item">
                            <a href="{{route('City.index')}}" class="sidebar-link">
                                <i class="mdi mdi-email"></i>
                                <span class="hide-menu">  المحافظات </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{route('Area.index')}}" class="sidebar-link">
                                <i class="mdi mdi-email"></i>
                                <span class="hide-menu">  المناطق </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('categories.index')}}" aria-expanded="false">
                                <i class="fa fa-info-circle"></i>
                                <span class="hide-menu">الاقسام الرئيسية</span>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-Mailbox-Empty"></i>
                        <span class="hide-menu">الاعضاء </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">

                        <li class="sidebar-item">
                            <a href="{{route('User.index')}}" class="sidebar-link">
                                <i class="mdi mdi-email"></i>
                                <span class="hide-menu">  الاعضاء </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{route('User.index',['user_type'=>2])}}" class="sidebar-link">
                                <i class="mdi mdi-email"></i>
                                <span class="hide-menu">  المتاجر </span>
                            </a>
                        </li>
                    </ul>
                </li>
                {{--End USers --}}
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-Mailbox-Empty"></i>
                        <span class="hide-menu">خدماتنا </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">

                        <li class="sidebar-item">
                            <a href="{{route('Advices.index')}}" class="sidebar-link">
                                <i class="mdi mdi-email"></i>
                                <span class="hide-menu">  النصائح </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('Courses.index')}}" class="sidebar-link">
                                <i class="fa fa-calendar"></i>
                                <span class="hide-menu">الكورسات</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('Jobs.index')}}" aria-expanded="false">
                                <i class="fa fa-address-card"></i>
                                <span class="hide-menu">الوظائف</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('Product.index')}}" aria-expanded="false">
                        <i class="fab  fa-product-hunt"></i>
                        <span class="hide-menu">المنتجات</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">روابط اخرى</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('Slider.index')}}" aria-expanded="false">
                        <i class="fa fa-image"></i>
                        <span class="hide-menu">الاعلانات</span>
                    </a>
                </li>



                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('Packages.index')}}" aria-expanded="false">
                        <i class="fa fa-cart-arrow-down"></i>
                        <span class="hide-menu">الباقات</span>
                    </a>
                </li>



                {{-- Our services --}}



            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
