    <div class="login-box">

        <?php if($this->session->flashdata('success')): ?>
              <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <?=$this->session->flashdata('success')?>
              </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('warning')): ?>
             <div class="alert alert-warning">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
              <?=$this->session->flashdata('warning')?>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
             <div class="alert alert-danger">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
              <?=$this->session->flashdata('error')?>
            </div>
        <?php endif; ?>
        <?php if( validation_errors() !== ''): ?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                <?= validation_errors();?>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="body">
                Terms & Conditions.....
            </div>
        </div>
    </div>