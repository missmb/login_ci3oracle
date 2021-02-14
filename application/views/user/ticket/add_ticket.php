<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row auto">
        <div class="col-lg-8">
            <form action="<?= base_url('user/addticket'); ?>" method="POST">
                <div class="form-group row">
                    <label for="user_enter" class="col-sm-4 col-form-label">Username</label>
                    <div class="col-sm-8">
                        <select name="user_enter" id="user_enter" class="form-control">
                            <option value="">Select Username</option>
                            <?php foreach ($username as $v) : ?>
                                <option value="<?= $v['ID_USER']; ?>"><?= $v['NAME']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="transport" class="col-sm-4 col-form-label">Transportation</label>
                    <div class="col-sm-8">
                        <select name="transport" id="transport" class="form-control">
                            <option value="">Select Transportation</option>
                            <?php foreach ($transport as $v) : ?>
                                <option value="<?= $v['TRANSPORT_ID']; ?>"><?= $v['TYPE']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="parking" class="col-sm-4 col-form-label">Parking Area</label>
                    <div class="col-sm-8">
                        <select name="parking" id="parking" class="form-control">
                            <option value="">Select Parking Area</option>
                            <?php foreach ($parking as $v) : ?>
                                <option value="<?= $v['PARKING_ID']; ?>"><?= $v['AREA']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="license_plate" class="col-sm-4 col-form-label">License Plate</label>
                    <div class="col-sm-8">
                        <input type="text" name="license_plate" id="license_plate" class="form-control">
                        <?= form_error('license_plate', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="stnk" class="col-sm-4 col-form-label">STNK</label>
                    <div class="col-sm-8">
                        <input type="text" name="stnk" id="stnk" class="form-control">
                        <?= form_error('stnk', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group-row justify-content-end margin-between row">
                    <div>
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>