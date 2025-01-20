<?php

use yii\helpers\Url;
$baseUrl = Url::base();

use ybsisgood\modules\UserManagement\models\User;

?>
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>
                <li>
                    <a href="<?= Url::toRoute(['/site/index']) ?>"
                        class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <?php if (User::hasRole('admin') || User::hasPermission('appsAccess')):?>
                <li>
                    <a href="<?= Url::toRoute(['/apps']) ?>" class="waves-effect">
                        <i class="bx bx-server"></i>
                        <span key="t-apps">Apps</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(User::hasRole('admin') || User::hasPermission('employeeAccess')):?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-user"></i>
                    <span key="t-employee-menu">Employee</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="<?= Url::toRoute(['/employees']) ?>" key="t-list-employee">List Employee</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (User::hasRole('admin') || User::hasPermission('edcAccess')):?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-credit-card-alt"></i>
                    <span key="t-edc-menu">EDC</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="<?= Url::toRoute(['/edc/account']) ?>" key="t-list-account">Account</a></li>
                        <li><a href="<?= Url::toRoute(['/edc/category']) ?>" key="t-list-category">Category</a></li>
                        <li><a href="<?= Url::toRoute(['/edc/channel']) ?>" key="t-list-channel">Channel</a></li>
                        <li><a href="<?= Url::toRoute(['/edc/outlet']) ?>" key="t-list-outlet">Outlet</a></li>
                        <li><a href="<?= Url::toRoute(['/edc/payment']) ?>" key="t-list-payment">Payment</a></li>
                        <li><a href="<?= Url::toRoute(['/edc/serial-key']) ?>" key="t-list-serial-key">Serial Key</a></li>
                        <li><a href="<?= Url::toRoute(['/edc/vendor']) ?>" key="t-list-vendor">Vendor</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (User::hasRole('admin') || User::hasPermission('userAccess') || User::hasPermission('roleAccess')):?>
                <li class="menu-title" key="t-user-management">User Management</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-user-circle"></i>
                    <span key="t-user-menu">User</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <?php if (User::hasRole('admin') || User::hasPermission('userAccess')):?>
                        <li><a href="<?= Url::toRoute(['/user-management/user']) ?>" key="t-list-user">List User</a></li>
                        <?php endif; ?>
                        <?php if (User::hasRole('admin') || User::hasPermission('roleAccess')):?>
                        <li><a href="<?= Url::toRoute(['/user-management/role']) ?>" key="t-role">Roles</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (User::hasPermission('permissionAccess')):?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-run"></i>
                    <span key="t-permission-menu">Permission</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="<?= Url::toRoute(['/user-management/auth-item-group']) ?>" key="t-role-permission">Role Group</a></li>
                        <li><a href="<?= Url::toRoute(['/user-management/permission']) ?>" key="t-list-permission">List Permission</a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
