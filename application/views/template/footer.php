            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Light Website <?= date('Y'); ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap core JavaScript-->
            <script src="<?= base_url('assets'); ?>/vendor/jquery/jquery.min.js"></script>
            <script src="<?= base_url('assets'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="<?= base_url('assets'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="<?= base_url('assets'); ?>/js/sb-admin-2.min.js"></script>

            <!--using jQuerry -->
            <script>
                $('.custom-file-input').on('change', function() {
                    let fileName = $(this).val().split('\\').pop();
                    $(this).next('.custom-file-label').addClass("selected").html(fileName);
                });





                $('.form-check-input').on('click', function() {
                    const menuId = $(this).data('menu');
                    const roleId = $(this).data('role');

                    $.ajax({
                        url: "<?= base_url('admin/changeaccess'); ?>",
                        type: 'post',
                        data: {
                            menuId: menuId,
                            roleId: roleId
                        },
                        success: function() {
                            document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
                        }
                    });
                    console.log("<?= base_url('admin/roleaccess/'); ?>" + roleId);
                    console.log(menuId);
                });

                $('#editMenu').on('show.bs.modal', function(event) {
                    let id = $(event.relatedTarget).data('id')
                    let menu = $(event.relatedTarget).data('menu')
                    $(this).find('.modal-body #menu_id').val(id)
                    $(this).find('.modal-body #menu').val(menu)
                })

                $('#editSubMenu').on('show.bs.modal', function(event) {
                    let id = $(event.relatedTarget).data('id')
                    let menu_id = $(event.relatedTarget).data('menu_id')
                    let title = $(event.relatedTarget).data('title')
                    let url = $(event.relatedTarget).data('url')
                    let icon = $(event.relatedTarget).data('icon')
                    let is_active = $(event.relatedTarget).data('is_active')
                    $(this).find('.modal-body #id').val(id)
                    $(this).find('.modal-body #menu_id').val(menu_id)
                    $(this).find('.modal-body #title').val(title)
                    $(this).find('.modal-body #url').val(url)
                    $(this).find('.modal-body #icon').val(icon)
                    $(this).find('.modal-body #is_active').val(is_active)
                })

                $('#editArea').on('show.bs.modal', function(event) {
                    let parking_id = $(event.relatedTarget).data('parking_id')
                    let area = $(event.relatedTarget).data('area')
                    $(this).find('.modal-body #parking_id').val(parking_id)
                    $(this).find('.modal-body #area').val(area)
                })
            </script>
            </body>

            </html>