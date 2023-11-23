<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('manager/dashboard') }}" class="nav-link">Dashboard</a>
        </li> -->
    </ul>

    <ul class="navbar-nav ml-auto">
              <!-- User Dropdown Menu -->
      <li class="nav-item dropdown text-center mx-3" >
        <a class="nav-link" data-toggle="dropdown" href="#"
        style="border: 2px solid #ccc;
            border-radius: 25px;
            padding: 2px 4px;"
        >
        <img src="https://img.icons8.com/color/30/null/user.png"/>

        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

          <div class="dropdown-divider"></div>
          <!-- profile -->
          <a href="{{ url('manager/profile/view') }}" class="dropdown-item">
          <img src="https://img.icons8.com/ios-glyphs/20/null/user--v1.png"/>
             View Profile
          </a>

          <a href="{{ url('manager/profile/change-password') }}" class="dropdown-item">
          <img src="https://img.icons8.com/ios-glyphs/20/null/private-lock.png"/>
             change password
          </a>

          <div class="dropdown-divider"></div>
          <!-- Logout -->
          <a href="{{ route('manager.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">

            <form action="{{ route('manager.logout') }}" id="logout-form" method="POST">
                @csrf
            </form>
          <img src="https://img.icons8.com/ios-filled/20/null/logout-rounded.png"/>
            Logout
          </a>

        </div>
      </li>

    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:#2a3f5a; height: 270vh; overflow: hidden;">
    <!-- Brand Logo -->
    <a href="{{ url('manager/dashboard') }}" class="brand-link" style=" border-bottom: none;">
        <img src="{{ asset('dashboard/dist/img/fitlife-logo.png') }}" alt="AdminLTE Logo" class="brand-image  w-100" style="opacity: 1; max-height: none;    margin-left: 0%">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- dashboard -->
                <li class="nav-item">
                    <a href="{{ url('manager/dashboard') }}" class="nav-link ">
                    <img src="https://img.icons8.com/material-outlined/20/EBEBEB/dashboard-layout.png"/>
                        <!-- <i class="nav-icon fas fa-tachometer-alt"></i> -->
                        <p class="mx-2">
                            Dashboard
                            <!-- <i class="right fas fa-angle-left"></i> -->
                        </p>
                    </a>

                    <!-- <ul class="nav nav-treeview">

                    </ul> -->
                </li>
                <!-- exercises -->
                <li class="nav-item">
                    <a class="nav-link ">
                    <img src="https://img.icons8.com/external-ddara-fill-ddara/20/FFFFFF/external-yoga-yoga-poses-ddara-fill-ddara-24.png"/>
                        <!-- <i class="nav-icon fas fa-tachometer-alt"></i> -->
                        <p class="mx-2">
                            Exercises
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('manager/exercises/') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/exercise.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Exercises</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('manager/workouts') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/external-xnimrodx-lineal-xnimrodx/20/EBEBEB/external-workout-fitness-and-diet-xnimrodx-lineal-xnimrodx.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Workouts </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('manager/body-parts') }}" class="nav-link " style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/body-type-tall.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Body Parts</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('manager/equipments') }}" class="nav-link " style="padding-left: 20%;">
                            <img src="https://img.icons8.com/material-outlined/20/EBEBEB/hub.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Equipments</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('manager/exercise/levels') }}" class="nav-link " style="padding-left: 20%;">
                            <img src="https://img.icons8.com/external-prettycons-solid-prettycons/20/EBEBEB/external-settings-essentials-prettycons-solid-prettycons-2.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Levels</p>
                            </a>
                        </li>
                        <!-- Goals -->
                        <li class="nav-item">
                            <a href="{{ url('manager/exercise/goals') }}" class="nav-link " style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios-glyphs/20/EBEBEB/goal.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Goals</p>
                            </a>
                        </li>
                            <!-- Challenges -->
                            <li class="nav-item">
                            <a href="{{ url('manager/challenges') }}" class="nav-link " style="padding-left: 20%;">
                            <img src="https://img.icons8.com/external-sbts2018-outline-sbts2018/20/EBEBEB/external-challenge-basic-ui-elements-2.3-sbts2018-outline-sbts2018.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Challenges</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!----------------------------------------- Nutrition ---------------------------->
                <li class="nav-item">
                    <a class="nav-link">
                    <img src="https://img.icons8.com/ios-filled/20/FFFFFF/organic-food.png"/>
                        <!-- <i class="nav-icon fas fa-chart-pie"></i> -->
                        <p class="mx-2">
                        Nutrition
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('manager/nutrition/recipes') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/ingredients-for-cooking.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Recipes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('manager/nutrition/food-exchanges') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/food-bar.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Food Exchanges</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('manager/nutrition/food-types') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/mushbooh-food.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Food Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('manager/nutrition/meals') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/buffet-breakfast--v2.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">All Meals</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('manager/nutrition/measurement-units') }}" class="nav-link" style="padding-left: 20%;">
                                <img src="https://img.icons8.com/material-rounded/20/EBEBEB/org-unit.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Measurement Units</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('manager/nutrition/meal-types') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/meal.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">All Meal Types</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('manager/nutrition/meal-plans') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/box-of-cereal.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Meal Plans</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!------------------------------------- Tips-and Information ---------------------------------->
                <li class="nav-item">
                    <a class="nav-link">
                    <img src="https://img.icons8.com/fluency-systems-filled/20/FFFFFF/tip.png"/>
                        <!-- <i class="nav-icon fas fa-tree"></i> -->
                        <p class="mx-2">
                            Tips & Information
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('manager/categories') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/overview-pages-3.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('manager/posts') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/list--v1.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Posts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('manager/tags') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/tags--v1.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Tags</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('manager/tips/') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/windows/20/EBEBEB/tips-2.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Tips of The Day</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- Settings -->
                <li class="nav-item">
                    <a class="nav-link">
                    <img src="https://img.icons8.com/glyph-neue/20/FFFFFF/settings.png"/>
                        <!-- <i class="nav-icon fas fa-table"></i> -->
                        <p class="mx-2">
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('manager/settings') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAABVElEQVR4nMVUXUrDQBCOUnoOvYAKCQhS71B/Tqd9tYI9QB9K7asX0HgBm8z3LRV864srI7OwDUkMRnBgYDLzzZed2dlJkv8QkmPVviQTklOSKYBXADnJjOQ9ydtOJN77oSZ57wcAHkn6OgWwVIxhh22nyizhPSJYk4TpOiINmLTthIMABPDmnLvw3u+TfFBV2zl3GYgBbDSnjmhP+wJgYcCPoigOopN/E4ZvjSnGsAvNVY4q4TQq5xPAk3PuVESOATyrqq0+jSkmwt819k/LEZETACsj3kaJW/OtFBP1NK2SjW0sNDiP/DP1iciZiIwsPovic/tRvjOnHQhHAM47E/5ByVlSlaZLKcvyKFyK2nWXQnLad2wOK2NzszM2dYNtpV9VB1tErkkW4bX4usH+4ekV0dMro7ZsGvvXYzmkrcshlsr6ygG8qG2+SSeSFvL+C/a38gVy0gLsJWsyDQAAAABJRU5ErkJggg==">
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Settings</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('manager/program-types') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/user-typing-using-typewriter.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Programs Types</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('manager/plan-durations') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/project.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Plan Duration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('manager/plan-managements') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/what-i-do.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Plan Managements</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('manager/faqs/') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/faq.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">FAQs</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- users -->

                <li class="nav-item">
                    <a class="nav-link">
                    <img src="https://img.icons8.com/ios-glyphs/20/FFFFFF/batch-assign.png"/>
                        <!-- <i class="nav-icon fas fa-table"></i> -->
                        <p class="mx-2">
                        Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('manager/users') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/ios/20/EBEBEB/conference-call--v1.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Customers</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- Subscriptions -->
                <li class="nav-item">
                    <a class="nav-link">
                    <img src="https://img.icons8.com/external-glyph-silhouettes-icons-papa-vector/20/FFFFFF/external-Subscription-Program-loyalty-program-glyph-silhouettes-icons-papa-vector.png"/>
                        <!-- <i class="nav-icon fas fa-table"></i> -->
                        <p class="mx-2">
                        Subscriptions
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('manager/subscriptions') }}" class="nav-link" style="padding-left: 20%;">
                            <img src="https://img.icons8.com/external-wanicon-lineal-wanicon/20/EBEBEB/external-subscription-online-marketing-wanicon-lineal-wanicon.png"/>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">All</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- Marketing -->
                <li class="nav-item">
                    <a class="nav-link">
                        <i class="fa fa-ad"></i>
                        <!-- <i class="nav-icon fas fa-table"></i> -->
                        <p class="mx-2">
                            Marketing
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('manager/marketing/coupons') }}" class="nav-link" style="padding-left: 20%;">
                                <i class="fa fa-gift"></i>
                                <!-- <i class="far fa-circle nav-icon"></i> -->
                                <p class="mx-2">Coupons</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <div id="mCSB_1_scrollbar_vertical"
                     class="mCSB_scrollTools mCSB_1_scrollbar mCS-dark mCSB_scrollTools_vertical"
                     style="display: block;">
                    <div class="mCSB_draggerContainer">
                        <div id="mCSB_1_dragger_vertical" class="mCSB_dragger"
                             style="position: absolute; min-height: 30px; display: block; height: 90px; max-height: 203.172px; top: 0px;">
                            <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                        </div>
                        <div class="mCSB_draggerRail"></div>
                    </div>
                </div>

            </ul>
        </nav>
    </div>
</aside>
