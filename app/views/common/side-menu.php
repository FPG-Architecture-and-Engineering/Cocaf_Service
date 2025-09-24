    <!-- ########## START: LEFT PANEL ########## -->
    <div class="br-logo">
        <a href="/">
            <i class="fa fa-gears fa-lg"></i>
            <small class="text-number mg-l-4">
                <b>COCAF</b><span class="tx-11 text-muted">(CMS)</span>
            </small>
            <div class="by" style="left: 55px">Content Management System</div>
        </a>
    </div>
    <div class="br-sideleft overflow-y-auto">
        <label class="sidebar-label pd-x-10 mg-t-20 op-3">MENU</label>
        <ul class="br-sideleft-menu">
            <li class="br-menu-item">
                <a href="/" class="br-menu-link <?php activeDashboard('active'); ?>">
                    <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
                    <span class="menu-item-label">Dashboard</span>
                </a>
            </li>
            <li class="br-menu-item">
                <a href="#" class="br-menu-link with-sub <?php activeView(['transaction'], ['all', 'register', 'view'], 'active'); ?>">
                    <i class="fa fa-wpforms tx-20"></i>
                    <span class="menu-item-label">Transaction</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="/transaction/all" class="sub-link <?php activeView(['transaction'], ['all', 'view'], 'active'); ?>">All</a></li>
                    <?php if (accessGranted(['2'])) { ?>
                        <li class="sub-item"><a href="/transaction/register" class="sub-link <?php activeView(['transaction'], ['register'], 'active'); ?>">Register</a></li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
        <hr>

        <ul class="br-sideleft-menu">
            <li class="br-menu-item">
                <a href="/report/generation" class="br-menu-link <?php activeView(['report'], ['generation'], 'active'); ?>">
                    <i class="menu-item-icon icon ion-ios-paper-outline tx-22"></i>
                    <span class="menu-item-label">Reports Generation</span>
                </a>
            </li>
        </ul>
        <hr>

        <label class="sidebar-label pd-x-10 mg-t-20 op-3">MAINTENANCE</label>
        <ul class="br-sideleft-menu">
            <li class="br-menu-item">
                <a href="#" class="br-menu-link with-sub <?php activeView(['account'], ['user', 'role'], 'active'); ?>">
                    <i class="fa fa-users tx-18"></i>
                    <span class="menu-item-label">Accounts</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="/account/user" class="sub-link <?php activeView(['account'], ['user'], 'active'); ?>">Users</a></li>
                    <li class="sub-item"><a href="/account/role" class="sub-link <?php activeView(['account'], ['role'], 'active'); ?>">Role</a></li>
                </ul>
            </li>
            <li class="br-menu-item">
                <a href="#" class="br-menu-link with-sub <?php activeView(['master'], ['mv-type', 'premium-type'], 'active'); ?>">
                    <i class="menu-item-icon icon ion-ios-color-filter-outline tx-22"></i>
                    <span class="menu-item-label">Master</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="/master/mv-type" class="sub-link <?php activeView(['master'], ['mv-type'], 'active'); ?>">MV Type</a></li>
                    <li class="sub-item"><a href="/master/premium-type" class="sub-link <?php activeView(['master'], ['premium-type'], 'active'); ?>">Premium Type</a></li>
                </ul>
            </li>
            <?php if (accessGranted(['1'])) { ?>
                <li class="br-menu-item">
                    <a href="#" class="br-menu-link with-sub <?php activeView(['system'], ['configuration', 'email-notification'], 'active'); ?>">
                        <i class="menu-item-icon icon ion-ios-cog-outline tx-22"></i>
                        <span class="menu-item-label">Configuration</span>
                    </a>
                    <ul class="br-menu-sub">
                        <li class="sub-item"><a href="/system/configuration" class="sub-link <?php activeView(['system'], ['configuration'], 'active'); ?>">System</a></li>
                        <li class="sub-item"><a href="/system/email-notification" class="sub-link <?php activeView(['system'], ['email-notification'], 'active'); ?>">Email Notification</a></li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
        <hr>

        <label class="sidebar-label pd-x-10 mg-t-20 op-3">ACCOUNT</label>
        <ul class="br-sideleft-menu">  
            <li class="br-menu-item">
                <a href="/account/profile" class="br-menu-link <?php activeView(['account'], ['profile'], 'active'); ?>">
                    <i class="fa fa-user-circle tx-18"></i>
                    <span class="menu-item-label">Profile</span>
                </a>
            </li>                      
            <li class="br-menu-item">
                <a href="/logout" class="br-menu-link">
                    <i class="menu-item-icon icon ion-power tx-18"></i>
                    <span class="menu-item-label">Logout</span>
                </a>
            </li>
        </ul>
        <hr>
        <label class="sidebar-label pd-x-10 mg-t-30 mg-b-10">
            <a href="/" class="tx-info"><b>COCAF<br><small class="text-muted">[ Content Management System ]</small></b></a>
            <br>
            Powered by: <b>FPG I.T Department</b>
            <center>
                <div class="account-logo mg-t-15 mg-b-30">
                    <a href="https:ph.fpgins.com" target="_blank"><img src="/public/img/fpg-insurance.png" class="logo"></a>
                </div>
            </center>
        </label>
    </div>
    <!-- ########## END: LEFT PANEL ########## -->