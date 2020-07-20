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
            <?php if ($this->session->userdata('admin_type') == '2') { ?>
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
                <li id="admins">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">person</i>
                        <span>Admin</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="admin_add">
                            <a href="<?= base_url('admin/admins/admin_add'); ?>">Add New Admin</a>
                        </li>
                        <li id="admin_list">
                            <a href="<?= base_url('admin/admins'); ?>">Admins List</a>
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
            <?php } ?>
            <li id="exam_registration">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">people</i>
                    <span>Candidate Management</span>
                </a>
                <ul class="ml-menu">
                    <li id="exam_submission_list">
                        <a href="<?= base_url('admin/exam_registration/exam_submission_list'); ?>">List Submission
                        </a>
                    </li>
                    <li id="exam_list">
                        <a href="<?= base_url('admin/exam_registration'); ?>"> List Candidates</a>
                    </li>
                </ul>
            </li>
            <?php if ($this->session->userdata('admin_type') == '2') { ?>
                <li id="fee_management">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">attach_money</i>
                        <span>Exam Fee Management</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="fee_management_add">
                            <a href="<?= base_url('admin/fee_management/fee_management_add'); ?>">Add Fee</a>
                        </li>
                        <li id="fee_management_list">
                            <a href="<?= base_url('admin/fee_management'); ?>">List Fee</a>
                        </li>
                    </ul>
                </li>
                <li id="exam_attribute">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">note_add</i>
                        <span>Exam Attribute Management</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="exam_attribute_add">
                            <a href="<?= base_url('admin/exam_attribute/exam_attribute_add'); ?>">Add Attribute</a>
                        </li>
                        <li id="exam_attribute_list">
                            <a href="<?= base_url('admin/exam_attribute'); ?>">List Attribute</a>
                        </li>
                    </ul>
                </li>
                <li id="time_venue">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">event</i>
                        <span>Date & Venue Management</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="time_venue_add">
                            <a href="<?= base_url('admin/time_venue/time_venue_add'); ?>">Add Date & Venue</a>
                        </li>
                        <li id="time_venue_list">
                            <a href="<?= base_url('admin/time_venue'); ?>">List Date & Venue</a>
                        </li>
                    </ul>
                </li>
                <li id="grade_management">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">grading</i>
                        <span>Grade Management</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="grade_management_add">
                            <a href="<?= base_url('admin/grade_management/grade_management_add'); ?>">Add Grade</a>
                        </li>
                        <li id="grade_management_list">
                            <a href="<?= base_url('admin/grade_management'); ?>">List Grade</a>
                        </li>
                    </ul>
                </li>
                <li id="exam_suite">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">source</i>
                        <span>Exam Suite Management</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="exam_suite_add">
                            <a href="<?= base_url('admin/exam_suite/exam_suite_add'); ?>">Add Exam Suite</a>
                        </li>
                        <li id="exam_suite_list">
                            <a href="<?= base_url('admin/exam_suite'); ?>">List Exam Suite</a>
                        </li>
                    </ul>
                </li>
                <li id="voucher">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">content_paste</i>
                        <span>Voucher Management</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="voucher_add">
                            <a href="<?= base_url('admin/voucher/voucher_add'); ?>">Add Voucher</a>
                        </li>
                        <li id="voucher_list">
                            <a href="<?= base_url('admin/voucher'); ?>">List Voucher</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if ($this->session->userdata('admin_type') == '2') { ?>
                <li class="header"></li>
                <li id="general_settings">
                    <a href="<?= base_url('admin/general_settings'); ?>">
                        <i class="material-icons">settings</i>
                        <span>Settings</span>
                    </a>
                </li>
            <?php } ?>
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
