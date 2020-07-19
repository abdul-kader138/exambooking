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
                    <li id=""><a href="<?= base_url('user/profile'); ?>"><i class="material-icons">person</i>Profile</a>
                    </li>
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
            <li id="profile">
                <a href="<?= base_url('user/profile'); ?>">
                    <i class="material-icons">person</i>
                    <span>My Profile</span>
                </a>
            </li>
            <li id="exam_registration">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">assignment</i>
                    <span>Register for Exam</span>
                </a>
                <ul class="ml-menu">
                    <li id="exam_list">
                        <a href="<?= base_url('user/exam_registration'); ?>"> Candidates</a>
                    </li>
                    <li id="add_exam">
                        <a href="<?= base_url('user/exam_registration/add_exam'); ?>">Add New</a>
                    </li>
                   </ul>
            </li>
            <li id="exam_submission">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">view_list</i>
                    <span>My Exams</span>
                </a>
                <ul class="ml-menu">
                    <li id="exam_submission_list">
                        <a href="<?= base_url('user/exam_submission/exam_submission_list'); ?>">My Submission</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2020 Trinity Malaysia.
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->

<script>
    $("#<?= $cur_tab; ?>").addClass('active');
    $("#<?= $sub_tab; ?>").addClass('active');
</script>
