  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
          <div class="sidebar-brand-icon rotate-n-15">
              <i class="fas fa-code"></i>
          </div>
          <div class="sidebar-brand-text mx-3">LoginSys</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider">


      <?php foreach ($try as $m) : ?>
          <div class="sidebar-heading">
              <?= $m['MENU']; ?>
          </div>
          <!-- LOOPING SUB MENU -->
          <?php
            $menuId = $m['MENU_ID'];
            $querySubMenu =  "SELECT *
                                    FROM USER_SUB_MENU JOIN USER_MENU
                                    ON USER_SUB_MENU.MENU_ID = USER_MENU.MENU_ID
                                    WHERE USER_SUB_MENU.MENU_ID = $menuId
                                AND USER_SUB_MENU.IS_ACTIVE = 1
            ";
            $subMenu = $this->db->query($querySubMenu)->result_Array();
            ?>

          <?php foreach ($subMenu as $sm) : ?>
              <?php if ($title == $sm['TITLE']) : ?>
                  <li class="nav-item active">
                  <?php else : ?>
                  <li class="nav-item">
                  <?php endif; ?>
                  <a class="nav-link pb-0" href="<?= base_url($sm['URL']); ?>">
                      <i class="<?= $sm['ICON']; ?>"></i>
                      <span><?= $sm['TITLE']; ?></span></a>
                  </li>
              <?php endforeach; ?>
              <hr class="sidebar-divider mt-3">

          <?php endforeach; ?>

          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
                  <i class="fas fa-fw fa-sign-out-alt"></i>
                  <span>Logout</span></a>
          </li>
          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">

          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
              <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>

  </ul>
  <!-- End of Sidebar -->