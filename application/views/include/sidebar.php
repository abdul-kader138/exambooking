<?php $cur_tab = $this->uri->segment(2) == '' ? 'dashboard' : $this->uri->segment(2); ?>
<?php $sub_tab = $this->uri->segment(3) == '' ? 'dashboard' : $this->uri->segment(3); ?>

<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="<?= base_url() ?>public/images/user.png" width="48" height="48" alt="User"/>
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true"
                 aria-expanded="false"><?= strtoupper($this->session->userdata('name')); ?></div>
            <div class="email"><?= $this->session->userdata('email'); ?></div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li id=""><a href="<?= base_url('admin/profile'); ?>"><i
                                    class="material-icons">person</i>Profile</a></li>
                    <li role="seperator" class="divider"></li>
                    <li id=""><a href="<?= base_url('auth/logout'); ?>"><i class="material-icons">input</i>Sign Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header"></li>
            <li id="dashboard">
                <a href="<?= base_url('admin/dashboard'); ?>">
                    <i class="material-icons">home</i>
                    <span>Home</span>
                </a>
            </li>
            <li id="users">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">person</i>
                    <span>Users</span>
                </a>
                <ul class="ml-menu">
                    <li id="add">
                        <a href="<?= base_url('admin/users/add'); ?>">Add New User</a>
                    </li>
                    <li id="user_list">
                        <a href="<?= base_url('admin/users'); ?>">Users List</a>
                    </li>
                </ul>
            </li>
            <li id="admin">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">person</i>
                    <span>Admin</span>
                </a>
                <ul class="ml-menu">
                    <li id="addadmin">
                        <a href="#">Add New Admin</a>
                    </li>
                    <li id="admin_list">
                        <a href="#">Admin List</a>
                    </li>
                </ul>
            </li>
            <li id="branches">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">view_module</i>
                    <span>Branches</span>
                </a>
                <ul class="ml-menu">
                    <li id="branch_add">
                        <a href="<?= base_url('admin/branches/branch_add'); ?>">Add New Branch</a>
                    </li>
                    <li id="branch_list">
                        <a href="<?= base_url('admin/branches'); ?>">Branches List</a>
                    </li>
                </ul>
            </li>
            <li id="location">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">my_location</i>
                    <span>Locations</span>
                </a>
                <ul class="ml-menu">
                    <li id="country">
                        <a href="<?= base_url('admin/location/country'); ?>">Country</a>
                    </li>
                    <li id="state">
                        <a href="<?= base_url('admin/location/state'); ?>">State</a>
                    </li>
                    <li id="city">
                        <a href="<?= base_url('admin/location/city'); ?>">City</a>
                    </li>
                </ul>
            </li>
            <li id="activity">
                <a href="<?= base_url('admin/activity'); ?>">
                    <i class="material-icons">flag</i>
                    <span>Users Activity</span>
                </a>
            </li>
            <li id="general_settings">
                <a href="<?= base_url('admin/general_settings'); ?>">
                    <i class="material-icons">settings</i>
                    <span>Settings</span>
                </a>
            </li>


            <li class="header"></li>


            <li id="ci_examples">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">code</i>
                    <span>CI Examples</span>
                </a>
                <ul class="ml-menu">
                    <li id="simple_datatable">
                        <a href="<?= base_url('admin/ci_examples/simple_datatable'); ?>">Simple Datatable</a>
                    </li>
                    <li id="ajax_datatable">
                        <a href="<?= base_url('admin/ci_examples/ajax_datatable'); ?>">Ajax Datatable</a>
                    </li>
                    <li id="pagination">
                        <a href="<?= base_url('admin/ci_examples/pagination'); ?>">Pagination Examples</a>
                    </li>
                    <li id="file_upload">
                        <a href="<?= base_url('admin/ci_examples/file_upload'); ?>">File Upload</a>
                    </li>
                    <li id="multi_file_upload">
                        <a href="<?= base_url('admin/ci_examples/multi_file_upload'); ?>">Multiple Files Upload</a>
                    </li>
                    <li id="location">
                        <a href="<?= base_url('admin/ci_examples/location'); ?>">Locations</a>
                    </li>
                    <li id="charts">
                        <a href="<?= base_url('admin/ci_examples/charts'); ?>">Dynamic Charts</a>
                    </li>
                    <li id="advance_search">
                        <a href="<?= base_url('admin/ci_examples/advance_search'); ?>">Advance Search</a>
                    </li>
                </ul>
            </li>
            <li id="forms">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">assignment</i>
                    <span>Forms</span>
                </a>
                <ul class="ml-menu">
                    <li id="basic">
                        <a href="<?= base_url('admin/forms/basic'); ?>">Basic Form Elements</a>
                    </li>
                    <li id="advanced">
                        <a href="<?= base_url('admin/forms/advanced'); ?>">Advanced Form Elements</a>
                    </li>
                    <li id="examples">
                        <a href="<?= base_url('admin/forms/examples'); ?>">Form Examples</a>
                    </li>
                    <li id="validation">
                        <a href="<?= base_url('admin/forms/validation'); ?>">Form Validation</a>
                    </li>
                    <li id="wizard">
                        <a href="<?= base_url('admin/forms/wizard'); ?>">Form Wizard</a>
                    </li>
                    <li id="editors">
                        <a href="<?= base_url('admin/forms/editors'); ?>">Editors</a>
                    </li>
                </ul>
            </li>
            <li id="tables">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">view_list</i>
                    <span>Tables</span>
                </a>
                <ul class="ml-menu">
                    <li id="normal">
                        <a href="<?= base_url('admin/tables/normal'); ?>">Normal Tables</a>
                    </li>
                    <li id="jquery">
                        <a href="<?= base_url('admin/tables/jquery'); ?>">Jquery Datatables</a>
                    </li>
                    <li id="editable">
                        <a href="<?= base_url('admin/tables/editable'); ?>">Editable Tables</a>
                    </li>
                </ul>
            </li>
            <li id="examples">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">content_copy</i>
                    <span>Example Pages</span>
                </a>
                <ul class="ml-menu">
                    <li id="signin">
                        <a href="<?= base_url('admin/examples/signin'); ?>">Sign In</a>
                    </li>
                    <li id="signup">
                        <a href="<?= base_url('admin/examples/signup'); ?>">Sign Up</a>
                    </li>
                    <li id="forgot_password">
                        <a href="<?= base_url('admin/examples/forgot_password'); ?>">Forgot Password</a>
                    </li>
                    <li id="blank">
                        <a href="<?= base_url('admin/examples/blank'); ?>">Blank Page</a>
                    </li>
                    <li id="page_404">
                        <a href="<?= base_url('admin/examples/page_404'); ?>">404 - Not Found</a>
                    </li>
                    <li id="page_500">
                        <a href="<?= base_url('admin/examples/page_500'); ?>">500 - Server Error</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            <a href="javascript:void(0);"><?= $this->general_settings['copyright'] ?></a>.
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->

<script>
    $("#<?= $cur_tab; ?>").addClass('active');
    $("#<?= $sub_tab; ?>").addClass('active');
</script>