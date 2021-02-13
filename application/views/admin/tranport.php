<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newParkingModel">Add New Menu</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Transport Type</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($transport as $v) : ?>
                        <tr>
                            <th scope="col"><?= $i; ?></th>
                            <th scope="col"><?= $v['TYPE']; ?></th>
                            <th scope="col">
                                <a data-toggle="modal" data-transport_id=<?= $v['TRANSPORT_ID']; ?> data-transport="<?= $v['TYPE']; ?>" data-target="#editTransport" class="badge badge-success">edit</a>
                                <a href="<?= base_url('admin/deletetransport/' . $v['TRANSPORT_ID']); ?>" class="badge badge-danger">delete</a>
                            </th>
                        </tr>
                        <?php $i++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="newParkingModel" tabindex="-1" role="dialog" aria-labelledby="newParkingModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newParkingModelLabel">Add New Transportation</h5>
                <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/transport'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="type" name="type" placeholder="Type Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Area -->

<div class="modal fade" id="editTransport" tabindex="-1" role="dialog" aria-labelledby="editTransportLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTransportLabel">Edit Transport</h5>
                <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/transportedit'); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="transport_id" name="transport_id" value="">
                    <div class="form-group">
                        <input type="text" class="form-control" id="type" name="type" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
