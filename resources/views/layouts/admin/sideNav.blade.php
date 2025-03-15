<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="{{asset('assets/images/faces/face1.jpg')}}" alt="profile" />
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">{{Auth()->user()->name}}</span>
                  <span class="text-secondary text-small">Admin</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="{{route('dashboard')}}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li> -->
            <li class="nav-item {{ request()->is('customer/viewClients') || request()->is('view-client-details/*') ||  request()->is('Co-branding/*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('customer.viewClients') }}">
                  <span class="menu-title">View Customers</span>
                  <i class="mdi mdi-contacts menu-icon"></i>
                </a>
              </li>



            <li class="nav-item">
              <a class="nav-link" href="{{route('customer.add')}}">
                <span class="menu-title">Add Customers</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li>


            <!-- <li class="nav-item">
              <a class="nav-link" href="{{route('customer.viewClients')}}">
                <span class="menu-title">View Customers</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li> -->

          
              <li class="nav-item">
              <a class="nav-link" href="{{route('confirmEntryShow')}}">
                <span class="menu-title">View  Confirm Entry</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li> 

            <!-- <li class="nav-item">
              <a class="nav-link" href="{{route('servicesList')}}">
                <span class="menu-title">Services</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li>  -->

            <!-- <li class="nav-item">
              <a class="nav-link" href="{{route('rateCardList')}}">
                <span class="menu-title">Rate Cards</span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li>  -->


            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
                <span class="menu-title">Settings</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
              </a>
              <div class="collapse" id="ui-basic1">
                <ul class="nav flex-column sub-menu">
                 <li class="nav-item">
                    <a class="nav-link" href="{{route('servicesList')}}">Services</a>
                  </li>


                  <li class="nav-item">
                    <a class="nav-link" href="{{route('rateCardList')}}">Rate Cards</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="{{route('clarity.index')}}"> Clarity</a>
                  </li>
                 
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('item.index')}}"> Items</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="{{route('color.index')}}"> colors</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="{{route('metals.index')}}"> Metals</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="{{route('invoices.index')}}"> Invoice</a>
                  </li>

                 
                 
                  
                </ul>
              </div>
            </li>


            <!-- <li class="nav-item">
              <a class="nav-link" href="{{route('uploadIndex')}}">
                <span class="menu-title">Diamond Jewellery </span>
                <i class="mdi mdi-contacts menu-icon"></i>
              </a>
            </li>  -->

            

            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Job Cards</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('uploadIndex')}}">Diamond Jewellery</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('uploadGemCardIndex')}}">Gem Stones</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('diamondCardJobIndex')}}">Diamond Card Job</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="{{route('gemJeweleryCardJobIndex')}}">Gems Jewelery Card Job</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="{{route('uncutjewelleryIndex')}}">Un Cut Jewelery Card Job</a>
                  </li>
                </ul>
              </div>
            </li>



           
          </ul>
        </nav>