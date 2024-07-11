 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="index.php" class="brand-link">
         <img src="../assets/dist/img/logo/pkt-logo.jpg" alt="PKT Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">COT Officer Panel</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <?php if (file_exists('../assets/dist/img/user/' . user()['user_profile_picture']) && user()['user_profile_picture'] != 'default.jpg' && user()['user_profile_picture'] != '' && user()['user_profile_picture'] !== null) : ?>
                     <img src="../assets/dist/img/user/<?= user()['user_profile_picture'] ?>" class="img-circle elevation-2" alt="<?= user()['user_name'] ?>">
                 <?php else : ?>
                     <img src="../assets/dist/img/user/default.jpg" class="img-circle elevation-2" alt="<?= user()['user_name'] ?>">
                 <?php endif; ?>
             </div>
             <div class=" info">
                 <a href="#" class="d-block"><?= user()['user_name'] ?></a>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <li class="nav-item">
                     <a href="index.php" class="nav-link <?= $title == 'Dashboard' ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>
                 <li class="nav-item has-treeview <?= $title == 'Users' ? 'menu-open' : '' ?>">
                     <a href="#" class="nav-link <?= $title == 'Users' ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-user"></i>
                         <p>
                             Users
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="user-list.php?role=admin" class="nav-link <?= isset($_GET['role']) && $_GET['role'] == 'admin' ? 'active' : '' ?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Admin</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="user-list.php?role=cot_officer" class="nav-link <?= isset($_GET['role']) && $_GET['role'] == 'cot_officer' ? 'active' : '' ?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>COT Officers</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="user-list.php?role=pkt_management" class="nav-link <?= isset($_GET['role']) && $_GET['role'] == 'pkt_management' ? 'active' : '' ?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>PKT Management</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <!-- categories -->
                 <li class="nav-item">
                     <a href="category-list.php" class="nav-link <?= $title == "Categories" ? "active" : "" ?>">
                         <i class="nav-icon fas fa-list"></i>
                         <p>
                             Categories
                         </p>
                     </a>
                 </li>
                 <!-- account -->
                 <li class="nav-item">
                     <a href="account.php?action=profile" class="nav-link <?= $title == "Account" ? "active" : "" ?>">
                         <i class="nav-icon fas fa-user"></i>
                         <p>
                             Account
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#logout.php" class="nav-link" onclick="logout()">
                         <i class="nav-icon fas fa-sign-out-alt"></i>
                         <p>
                             Logout
                         </p>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>