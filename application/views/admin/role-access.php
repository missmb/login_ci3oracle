<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <h5>Role : <?= $role['role']; ?></h5>
    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Access</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($menu as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <th><?= $m['MENU']; ?></th>
                            <th>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" <?= check_access($role['ROLE_ID'], $m['MENU_ID']); ?> data-role="<?= $role['ROLE_ID']; ?>" data-menu="<?= $m['MENU_ID']; ?>">
                                </div>
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