<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 row">
                <a href="<?= base_url('user/addticket'); ?>" class="btn btn-tool"><i class="fas fa-plus"></i> Add Ticket
                </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTable_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="dataTable_length"><label>Show <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> entries</label></div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="dataTable_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable"></label></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Enter</th>
                                        <th>Exit</th>
                                        <th>User Enter</th>
                                        <th>Transportation</th>
                                        <th>Parking Area</th>
                                        <th>License Plate</th>
                                        <th>STNK</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Enter</th>
                                        <th>Exit</th>
                                        <th>User Enter</th>
                                        <th>Transportation</th>
                                        <th>Parking Area</th>
                                        <th>License Plate</th>
                                        <th>STNK</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($ticket as $key => $v) { ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $v['ENTER'] ?></td>
                                            <td class="text-center"><?php if ($v['EXIT'] == (NULL)) { ?>
                                                   <a href="<?= base_url('user/exituser/' . $v['TICKET_ID']); ?>" ><i class="fa fa-times"></i></a>
                                               <?php } else {
                                                   echo $v['EXIT'];
                                                } ?></td>
                                            <td><?= $v['NAME'] ?></td>
                                            <td><?= $v['TYPE'] ?></td>
                                            <td><?= $v['AREA'] ?></td>
                                            <td><?= $v['LICENSE_PLATE'] ?></td>
                                            <td><?= $v['STNK'] ?></td>
                                            <td class="text-center">
                                                <?php if ($v['STATUS'] == 'Parked') {
                                                    echo '<i class="fas fa-fw fa-user text-success"></i>';
                                                } elseif ($v['STATUS'] == 'Exit') {
                                                    echo '<i class="fas fa-fw fa-check text-danger"></i>';
                                                } elseif ($v['STATUS'] == 'Timeout') {
                                                    echo '<i class="fas fa-fw fa-exclamation-triangle text-warning"></i>';
                                                } ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                <ul class="pagination">
                                    <li class="paginate_button page-item previous disabled" id="dataTable_previous"><a href="#" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                                    <li class="paginate_button page-item active"><a href="#" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                                    <li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                                    <li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                                    <li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
                                    <li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="5" tabindex="0" class="page-link">5</a></li>
                                    <li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="6" tabindex="0" class="page-link">6</a></li>
                                    <li class="paginate_button page-item next" id="dataTable_next"><a href="#" aria-controls="dataTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->