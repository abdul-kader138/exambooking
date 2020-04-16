<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>

    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">face</i>
                </div>
                <div class="content">
                    <div class="text">NEW USERS</div>
                    <div class="number count-to" data-from="0" data-to="<?= $all_users->total; ?>" data-speed="15" data-fresh-interval="20"><?= $all_users->total; ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">people</i>
                </div>
                <div class="content">
                    <div class="text">ACTIVE USERS</div>
                    <div class="number count-to" data-from="0" data-to="<?= $active_users->total; ?>" data-speed="1000" data-fresh-interval="20"><?= $active_users->total; ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">block</i>
                </div>
                <div class="content">
                    <div class="text">INACTIVE USERS</div>
                    <div class="number count-to" data-from="0" data-to="<?= $deactive_users->total; ?>" data-speed="1000" data-fresh-interval="20"><?= $deactive_users->total; ?></div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Widgets -->
</div>

</div>

<!-- ======================= Scripts for this page ============================== -->
<!-- Jquery CountTo Plugin Js -->
<script src="<?= base_url()?>public/plugins/jquery-countto/jquery.countTo.js"></script>

<!-- Custom Js -->
<script src="<?= base_url()?>public/js/pages/index.js"></script>
