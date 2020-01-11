<?php 
    $dataMenuAssigned=array();
    $dataMenuAssigned=StaticDataController::dataMenuAssigned();
    //dd($dataMenuAssigned);
    if(empty($dataMenuAssigned))
    {
        ?>
        <script type="text/javascript">
            logoutFRM();
        </script>
        <?php
    }


    $datauserGuideSet=StaticDataController::userGuideSet();
    $userGuidefile="adminUserGuide.pdf";
    if(!empty($datauserGuideSet))
    {
        if($datauserGuideSet==4)
        {
            $userGuidefile="cashierUserGuide.pdf";
        }
    }

    $userGuideLink=url($userGuidefile);

    //echo $userGuideLink; die();

    //print_r($dataMenuAssigned); die();
?>

<aside id="sidebar-left" class="sidebar-circle">
        <style type="text/css">
            .avatarside img {
                width: 100%;
                max-width: 100%;
                height: auto;
                border: 0;
                border-radius: 1000px;
            }

            .sidebar-content img {
                width: 49px !important;
                height: 49px !important;
                margin-right: 3px;
                padding: 5px;
            }
        </style>
        <!-- Start left navigation - profile shortcut -->
        <div id="tour-8" class="sidebar-content" style="padding-top: 20px;">
            <div class="media">
                <a class="pull-left avatarside" href="{{url('pos')}}">
                    <img src="{{asset('gym/logo.png')}}" alt="admin">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"> GoFIT </h4>
                    <small>Total GYM Solutions</small>
                </div>
            </div>
        </div><!-- /.sidebar-content -->
        <!--/ End left navigation -  profile shortcut -->

        <!-- Start left navigation - menu -->
        <ul id="tour-9" class="sidebar-menu">
            <li class="sidebar-category">
                <span>System Quick Links</span>
                <span class="pull-right"><i class="fa fa-link"></i></span>
            </li>
            <!-- Start navigation - dashboard -->
            @if(in_array('dashboard', $dataMenuAssigned))
            <li class="">
                <a href="{{url('dashboard')}}">
                    <span class="icon"><i class="fa fa-dashboard"></i></span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            @endif

            @if(in_array('admission', $dataMenuAssigned))
            <!--/ End navigation - dashboard -->
            <li class="{{ Request::path() == 'admission' ? 'active' : '' }}">
                <a href="{{url('admission')}}">
                    <span class="icon"><i class="fa fa-plus"></i></span>
                    <span class="text">New Admission</span>
                </a>
            </li>
            @endif
            
            @if(in_array('gympayment', $dataMenuAssigned))
            <!--/ End navigation - dashboard -->
            <li class="{{ Request::path() == 'gympayment' ? 'active' : '' }}">
                <a href="{{url('gympayment')}}">
                    <span class="icon"><i class="fa fa-money"></i></span>
                    <span class="text">Receive Payment</span>
                </a>
            </li>
            @endif

            @if(in_array('customermain', $dataMenuAssigned))
            <!-- Start navigation - frontend themes -->
            <li class="submenu">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-user"></i></span>
                    <span class="text">Member / Staff</span>
                    <span class="arrow"></span>
                </a>
                <ul>

                    @if(in_array('customer', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'customer' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('customer')}}" class="menu-item">Add New Member / Staff</a></li>
                    @endif
                    @if(in_array('customer/list', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'customer/list' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('customer/list')}}" class="menu-item">Member / Staff List</a></li>
                    @endif
                    
                   {{--  @if(in_array('customer/lead/new', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'customer/lead/new' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('customer/lead/new')}}" class="menu-item">Add New Lead</a></li>
                    @endif
                    @if(in_array('customer/lead/list', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'customer/lead/list' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('customer/lead/list')}}" class="menu-item">Lead List</a></li>
                    @endif  --}}

                    @if(in_array('customer/import', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'customer/import' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('customer/import')}}" class="menu-item">Import Device Member / User</a></li>
                    @endif 
                </ul>
            </li>
            @endif

            @if(in_array('expense/voucher', $dataMenuAssigned))
            <li class="{{ Request::path() == 'expense/voucher' ? 'active' : '' }}">
                <a href="{{url('expense/voucher')}}">
                    <span class="icon"><i class="fa fa-shopping-basket"></i></span>
                    <span class="text">Expense Voucher</span>
                </a>
            </li>
            @endif 
     
            <!--/ End navigation - frontend themes -->
            @if(in_array('reports', $dataMenuAssigned) || in_array('system-setting', $dataMenuAssigned))
            <!-- Start category apps -->
            <li class="sidebar-category">
                <span> Reports & Settings</span>
                <span class="pull-right"><i class="fa fa-pie-chart"></i> <i class="fa fa-cog"></i></span>
            </li>
             @endif 
            <!--/ End category apps -->
            @if(in_array('reports', $dataMenuAssigned))
            <!-- Start navigation - blog -->
            <li class="submenu">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-area-chart"></i></span>
                    <span class="text">Reports</span>
                    <span class="arrow"></span>
                </a>
                <ul>
                    @if(in_array('admission/report', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'admission/report' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('admission/report')}}" class="menu-item">Admission Report</a></li>
                    @endif 
                    @if(in_array('attendance/punch/report', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'attendance/punch/report' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('attendance/punch/report')}}" class="menu-item">Attendance Punch Report</a></li>
                    @endif 

                   
                    @if(in_array('expense/voucher/report', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'expense/voucher/report' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/expense/voucher/report')}}" class="menu-item">Expense Voucher Report</a></li>
                    @endif 

                    @if(in_array('payment/report', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'payment/report' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/payment/report')}}" class="menu-item">Payment Report</a></li>
                    @endif 

                   @if(in_array('today/payment/report', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'today/payment/report' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/today/payment/report')}}" class="menu-item">Today Payment Report</a></li>
                    @endif 
                    

                    
                    
                    
                </ul>
            </li>
            @endif 
            @if(in_array('system-setting', $dataMenuAssigned))
            <li class="submenu">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-connectdevelop"></i></span>
                    <span class="text">System Setting</span>
                    <span class="arrow"></span>
                </a>
                <ul>
                    @if(in_array('tender', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'tender' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('/tender')}}" class="menu-item">Manage Tender</a></li>
                    @endif 

                    @if(in_array('gym/package', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'gym/package' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('/gym/package')}}" class="menu-item">Manage GYM Package</a></li>
                    @endif 

                    @if(in_array('device/settings', $dataMenuAssigned))
                    <li class="{{ Request::path() == 'device/settings' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('/device/settings')}}" class="menu-item">Manage Device Settings</a></li>
                    @endif 

                    
                    


                  
                    
                </ul>
            </li>
            @endif 
            
            @if(in_array('storesettings', $dataMenuAssigned)) 
            <li class="submenu">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa icon-home22"></i></span>
                    <span class="text">Store Setting</span>
                    <span class="arrow"></span>
                </a>
                <ul>
                    @if(in_array('store-shop', $dataMenuAssigned)) 
                    <li class="{{ Request::path() == 'store-shop' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('/store-shop')}}" class="menu-item">Add New Store</a></li>
                    @endif 
                    @if(in_array('store-shop/list', $dataMenuAssigned)) 
                    <li class="{{ Request::path() == 'store-shop/list' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/store-shop/list')}}" class="menu-item">Store List </a></li>
                    @endif 
                    @if(in_array('user', $dataMenuAssigned)) 
                    <li class="{{ Request::path() == 'user' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('/user')}}" class="menu-item">Add New User</a></li>
                    @endif 
                    @if(in_array('user/list', $dataMenuAssigned)) 
                    <li class="{{ Request::path() == 'user/list' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/user/list')}}" class="menu-item">User List </a></li>
                    @endif 
                    @if(in_array('attendance/punch/manual', $dataMenuAssigned)) 
                    <li class="{{ Request::path() == 'attendance/punch/manual' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/attendance/punch/manual')}}" class="menu-item">Add Manual Attendance </a></li>
                    @endif 
                    @if(in_array('role', $dataMenuAssigned)) 
                    <li class="{{ Request::path() == '/role' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/role')}}" class="menu-item">Role Setting</a></li>
                    @endif 
                    @if(in_array('menu-item', $dataMenuAssigned)) 
                    <li class="{{ Request::path() == '/menu-item' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/menu-item')}}" class="menu-item">Menu-Item Setting</a></li>
                    @endif 
                    @if(in_array('RoleWiseMenu', $dataMenuAssigned)) 
                    <li class="{{ Request::path() == '/RoleWiseMenu' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/RoleWiseMenu')}}" class="menu-item">Role Wise Menu Setting</a></li>
                    @endif 
                </ul>
            </li>
            @endif 
            <!--/ End navigation - blog -->
            
            <!--/ End documentation - api documentation -->

        </ul><!-- /.sidebar-menu -->
        <!--/ End left navigation - menu -->

        <div id="tour-10" class="sidebar-footer hidden-xs hidden-sm hidden-md">
        </div>
    </aside><!-- /#sidebar-left -->


<?php /*
{{-- 
<div data-scroll-to-active="true" class="main-menu menu-flipped menu-fixed menu-dark menu-bordereded menu-accordion menu-shadow">
      <!-- main menu header-->
      <!-- / main menu header-->
      <!-- main menu content-->
      <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
          <li class="nav-item {{ Request::path() == 'dashboard' ? 'active' : '' }} border-bottom-purple"><a href="{{url('dashboard')}}"><i class="icon-dashboard"></i><span data-i18n="nav.dash.main" class="menu-title">Dashboard</span>
          </a>
          </li>

          <li class=" nav-item border-bottom-purple">
            <a href="#">
              <i class="icon-cart"></i>
              <span class="menu-title">Sales</span>
            </a>
            <ul class="menu-content">
              <li class="{{ Request::path() == 'pos' ? 'active' : '' }} border-bottom-purple"><a href="{{url('pos')}}" class="menu-item">Point of Sales (POS)</a></li>
              <li class="{{ Request::path() == 'counter-display' ? 'active' : '' }} border-bottom-purple"><a href="{{url('counter-display')}}" class="menu-item">Counter Display</a></li>
              <li class="{{ Request::path() == 'sales' ? 'active' : '' }} border-bottom-purple"><a href="{{url('sales')}}" class="menu-item">Add New Sales</a></li>
              <li class="{{ Request::path() == 'sales/report' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('sales/report')}}" class="menu-item">Sales Report</a></li>

            </ul>
          </li>
          <li class=" nav-item border-bottom-purple">
            <a href="#">
              <i class="icon-user"></i>
              <span class="menu-title">Customer</span>
            </a>
            <ul class="menu-content">
              <li class="{{ Request::path() == 'customer' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('customer')}}" class="menu-item">Add New Customer</a></li>
              <li class="{{ Request::path() == 'customer/report' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('customer/report')}}" class="menu-item">Customer Report</a></li>
            </ul>
          </li>
          <li class=" nav-item  border-bottom-purple">
            <a href="#">
              <i class="icon-mobile"></i>
              <span class="menu-title">Product</span>
            </a>
              <ul class="menu-content">
                <li class="{{ Request::path() == 'product' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('product')}}" class="menu-item">Add New Product</a></li>
                <li class="{{ Request::path() == 'product/list' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('product/list')}}" class="menu-item">Product List</a></li>
              </ul>
          </li>
          <li class=" nav-item  border-bottom-purple">
            <a href="#">
              <i class="icon-stack"></i>
              <span class="menu-title">Product Stock In</span>
            </a>
              <ul class="menu-content">
                <li class="{{ Request::path() == 'product/stock/in' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('/product/stock/in')}}" class="menu-item">New Stock In</a></li>
                <li class="{{ Request::path() == 'product/stock/in/list' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('/product/stock/in/list')}}" class="menu-item">Stock In Order List</a></li>
              </ul>
          </li>
           <li class=" nav-item  border-bottom-purple">
            <a href="#">
              <i class="icon-credit-card"></i>
              <span class="menu-title">Tender</span>
            </a>
              <ul class="menu-content">
                <li class="{{ Request::path() == 'tender' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('/tender')}}" class="menu-item">Add New Tender</a></li>
                <li class="{{ Request::path() == 'tender/report' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('/tender/report')}}" class="menu-item">Tender Report</a></li>
              </ul>
          </li>
          <li class=" nav-item  border-bottom-purple">
            <a href="#">
              <i class="icon-archive2"></i>
              <span class="menu-title">Warranty</span>
            </a>
              <ul class="menu-content">
                <li  class="{{ Request::path() == 'warranty' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('/warranty')}}" class="menu-item">Create Warranty</a></li>
                <li class="{{ Request::path() == 'warranty/report' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/warranty/report')}}" class="menu-item">Warranty Report</a></li>
                <li class="{{ Request::path() == 'warranty/batch-out' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/warranty/batch-out')}}" class="menu-item">Warranty Batch Out</a></li>
              </ul>
          </li>

          <li class=" nav-item  border-bottom-purple">
            <a href="#">
              <i class="icon-gg"></i>
              <span class="menu-title">Variance</span>
            </a>
              <ul class="menu-content">
                <li  class="{{ Request::path() == 'variance/create' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/variance/create')}}" class="menu-item">Create Variance</a></li>
                <li  class="{{ Request::path() == 'variance/report' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/variance/report')}}" class="menu-item">Variance Report</a></li>
              </ul>
          </li>
          <li class=" nav-item border-bottom-purple">
            <a href="#">
              <i class="icon-television"></i>
              <span class="menu-title">Report</span>
            </a>
              <ul class="menu-content">
                <li class="{{ Request::path() == 'profit/report' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/profit/report')}}" class="menu-item">Profit Report</a></li>
                <li class="{{ Request::path() == 'payment/report' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/payment/report')}}" class="menu-item">Payment Report</a></li>
                <li class="{{ Request::path() == 'product/report' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/product/report')}}" class="menu-item">product Status Report</a></li>
                <li class="{{ Request::path() == 'product/stock/in/report' ? 'active' : '' }} border-bottom-purple"><a href="{{url('product/stock/in/report')}}" class="menu-item">product Stockin  Report</a></li>
              </ul>
          </li>
          <li class=" nav-item border-bottom-purple">
            <a href="#">
              <i class="icon-stack-2"></i>
              <span class="menu-title">Setting</span>
            </a>
              <ul class="menu-content">
                <li class="{{ Request::path() == '/pos/settings' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/pos/settings')}}" class="menu-item">POS Setting</a></li>
                {{-- <li class="{{ Request::path() == '/setting' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/setting')}}" class="menu-item">Setting</a></li> --}}
                <li class="{{ Request::path() == 'site/navigation' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/site/navigation')}}" class="menu-item">Navigation Setting</a></li>
                <li class="{{ Request::path() == 'counter/display/add' ? 'active' : '' }} border-bottom-purple"><a href="{{url('counter/display/add')}}" class="menu-item">Counter Display Add/Remove</a></li>
                <li class="{{ Request::path() == 'site/color' ? 'active' : '' }} border-bottom-purple"><a href="{{url('/site/color')}}" class="menu-item">Color Plate</a></li>
              </ul>
          </li>
          <li class="nav-item border-bottom-purple"><a href="javascript:void(0);"><i class="icon-android-globe"></i><span data-i18n="nav.dash.main" class="menu-title">{{$_SERVER['REMOTE_ADDR']}}</span>
          </a>
          </li>
        </ul>
      </div>

 --}} */ ?>
 @section('js')
 <script type="text/javascript">
     $(document).ready(function(){
            $("#copyButton").click(function(){
                copyToClipboard(document.getElementById("copyTarget"));
            });
     });
     /*document.getElementById("copyButton").addEventListener("click", function() {
    copyToClipboard(document.getElementById("copyTarget"));
});*/

function copyToClipboard(elem) {
      // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
          succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}
 </script>
 @endsection