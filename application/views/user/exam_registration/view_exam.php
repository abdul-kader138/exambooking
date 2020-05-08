<div class="container-fluid">
    <!-- Basic Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Exam Details (ID- <?=$records->id ?>)
                    </h2>
                    <a href="<?= base_url('user/exam_registration/');?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">list</i> Candidates </a>

                </div>
                <div class="body table-responsive">
                    <div class="row">
                        <table class="table">

                            <tbody>
                            <tr>
                                <td>Full Name :</td>
                                <td><?=$records->first_name." ".$records->last_name?></td>
                                <td>|</td>
                                <td>Date Of Birth :</td>
                                <td><?=$this->functions->reformatDate($records->dob)?></td>
                            </tr>
                            <tr>
                                <td>Gender :</td>
                                <td><?=$records->gender?></td>
                                <td>|</td>
                                <td>Voucher Code</td>
                                <td><?=$records->voucher_code?></td>
                            </tr>
                            <tr>
                                <td>School Name :</td>
                                <td><?=$records->school_name?></td>
                                <td>|</td>
                                <td>Time & Venue :</td>
                                <td><?=$records->time_venue?></td>
                            </tr>
                            <tr>
                                <td>Exam Type :</td>
                                <td><?=$records->type_name?></td>
                                <td>|</td>
                                <td>Type :</td>
                                <td><?=$records->type_type?></td>
                            </tr>
                            <tr>
                                <td>Instrument/Product/Category :</td>
                                <td><?=$records->instrument_name?></td>
                                <td>|</td>
                                <td>Grade/Diploma :</td>
                                <td><?=$records->grade_name?></td>
                            </tr>
                            <tr>
                                <td>Group Name :</td>
                                <td><?=$records->group_name?></td>
                                <td>|</td>
                                <td>Exam Suite :</td>
                                <td><?=$records->exam_suite?></td>
                            </tr>
                            <tr>
                                <td>Fees :</td>
                                <td><?=$records->fees?></td>
                                <td>|</td>
                                <td>Submitted :</td>
                                <td><?=$records->submitted?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Basic Table -->
    <!-- Striped Rows -->
    <!-- #END# With Material Design Colors -->
</div>