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
                    <li id="exam_submission_search">
                        <a href="<?= base_url('admin/exam_registration/exam_submission_search'); ?>"> Export
                            Candidates</a>
                    </li>
                    <?php if ($this->session->userdata('admin_type') == '2') { ?>
                        <li id="update_candidates">
                            <a href="<?= base_url('admin/exam_registration/update_candidates'); ?>"> Update Candidates
                                (XLS)</a>
                        </li>
                        <li id="update_voucher">
                            <a href="<?= base_url('admin/exam_registration/update_voucher'); ?>"> Create Voucher
                                (XLS)</a>
                        </li>
                    <?php } ?>
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
                <li id="submission_time">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">post_add</i>
                        <span>Submission Time Management</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="submission_time_add">
                            <a href="<?= base_url('admin/submission_time/submission_time_add'); ?>">Add Submission Time</a>
                        </li>
                        <li id="submission_time_list">
                            <a href="<?= base_url('admin/submission_time'); ?>">List Submission Time</a>
                        </li>
                    </ul>
                </li>

                <li id="overtime_submission">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">post_add</i>
                        <span>Overtime Code Management</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="overtime_submission_add">
                            <a href="<?= base_url('admin/overtime_submission/overtime_submission_add'); ?>">Add Overtime Code</a>
                        </li>
                        <li id="overtime_submission_list">
                            <a href="<?= base_url('admin/overtime_submission'); ?>">List Overtime Code</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if ($this->session->userdata('admin_type') == '2') { ?>
                <li class="header"></li>
            <?php } ?>

            <!--            <li id="ci_examples">-->
            <!--                <a href="javascript:void(0);" class="menu-toggle">-->
            <!--                    <i class="material-icons">code</i>-->
            <!--                    <span>CI Examples</span>-->
            <!--                </a>-->
            <!--                <ul class="ml-menu">-->
            <!--                    <li id="simple_datatable">-->
            <!--                        <a href="-->
            <? //= base_url('admin/ci_examples/simple_datatable'); ?><!--">Simple Datatable</a>-->
            <!--                    </li>-->
            <!--                    <li id="ajax_datatable">-->
            <!--                        <a href="-->
            <? //= base_url('admin/ci_examples/ajax_datatable'); ?><!--">Ajax Datatable</a>-->
            <!--                    </li>-->
            <!--                    <li id="pagination">-->
            <!--                        <a href="-->
            <? //= base_url('admin/ci_examples/pagination'); ?><!--">Pagination Examples</a>-->
            <!--                    </li>-->
            <!--                    <li id="file_upload">-->
            <!--                        <a href="-->
            <? //= base_url('admin/ci_examples/file_upload'); ?><!--">File Upload</a>-->
            <!--                    </li>-->
            <!--                    <li id="multi_file_upload">-->
            <!--                        <a href="-->
            <? //= base_url('admin/ci_examples/multi_file_upload'); ?><!--">Multiple Files Upload</a>-->
            <!--                    </li>-->
            <!--                    <li id="location">-->
            <!--                        <a href="-->
            <? //= base_url('admin/ci_examples/location'); ?><!--">Locations</a>-->
            <!--                    </li>-->
            <!--                    <li id="charts">-->
            <!--                        <a href="-->
            <? //= base_url('admin/ci_examples/charts'); ?><!--">Dynamic Charts</a>-->
            <!--                    </li>-->
            <!--                    <li id="advance_search">-->
            <!--                        <a href="-->
            <? //= base_url('admin/ci_examples/advance_search'); ?><!--">Advance Search</a>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--            </li>-->
            <!--            <li id="forms">-->
            <!--                <a href="javascript:void(0);" class="menu-toggle">-->
            <!--                    <i class="material-icons">assignment</i>-->
            <!--                    <span>Forms</span>-->
            <!--                </a>-->
            <!--                <ul class="ml-menu">-->
            <!--                    <li id="basic">-->
            <!--                        <a href="-->
            <? //= base_url('admin/forms/basic'); ?><!--">Basic Form Elements</a>-->
            <!--                    </li>-->
            <!--                    <li id="advanced">-->
            <!--                        <a href="-->
            <? //= base_url('admin/forms/advanced'); ?><!--">Advanced Form Elements</a>-->
            <!--                    </li>-->
            <!--                    <li id="examples">-->
            <!--                        <a href="-->
            <? //= base_url('admin/forms/examples'); ?><!--">Form Examples</a>-->
            <!--                    </li>-->
            <!--                    <li id="validation">-->
            <!--                        <a href="-->
            <? //= base_url('admin/forms/validation'); ?><!--">Form Validation</a>-->
            <!--                    </li>-->
            <!--                    <li id="wizard">-->
            <!--                        <a href="--><? //= base_url('admin/forms/wizard'); ?><!--">Form Wizard</a>-->
            <!--                    </li>-->
            <!--                    <li id="editors">-->
            <!--                        <a href="--><? //= base_url('admin/forms/editors'); ?><!--">Editors</a>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--            </li>-->
            <!--            <li id="tables">-->
            <!--                <a href="javascript:void(0);" class="menu-toggle">-->
            <!--                    <i class="material-icons">view_list</i>-->
            <!--                    <span>Tables</span>-->
            <!--                </a>-->
            <!--                <ul class="ml-menu">-->
            <!--                    <li id="normal">-->
            <!--                        <a href="--><? //= base_url('admin/tables/normal'); ?><!--">Normal Tables</a>-->
            <!--                    </li>-->
            <!--                    <li id="jquery">-->
            <!--                        <a href="-->
            <? //= base_url('admin/tables/jquery'); ?><!--">Jquery Datatables</a>-->
            <!--                    </li>-->
            <!--                    <li id="editable">-->
            <!--                        <a href="-->
            <? //= base_url('admin/tables/editable'); ?><!--">Editable Tables</a>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--            </li>-->
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
