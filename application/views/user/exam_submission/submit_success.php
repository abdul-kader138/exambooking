<div class="container-fluid">
    <!-- Basic Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                        <h2>My Submission</h2>
                </div>
                <div class="body table-responsive">
                    <div class="row">
                        <div class="col-sm-12">
                            <b>Thank you! Your submission has been sent. Below is our bank account detail.</b><br>
                            Submission Date: <?=$this->functions->reformatDate($submission_details->created_date)?><br>
                            Ref No: <?=$submission_details->ref_no?><br>
                            Total Amount: <?=$submission_details->total_fees?><br>
                            Bank Name: xxxxx xxx xxxx <br>
                            Bank Acc No.: xxxx xxxx xxxx<br>
                            Kindly bank-in or online transfer the total amount to the above bank account, please included your Name and Ref No. for our referene.<br>
                            WhatsApp or email your bank slip to +6012-xxxx xxxx / booking@trinity.com.my.<br>
                            <br>
                            <br>
                            <a href="<?= base_url('user/exam_submission/exam_submission_list'); ?>"
                               class="btn bg-grey waves-effect">&nbsp;&nbsp; Ok&nbsp;&nbsp;</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Basic Table -->
    <!-- Striped Rows -->
    <!-- #END# With Material Design Colors -->
</div>
