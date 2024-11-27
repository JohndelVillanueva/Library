<header class="main-header">
  <a href="home.php" class="logo">
    <span class="logo-lg"><b><img src="../Westfields Badge.png" alt="Logo of Malino" style="width: 25px; height: auto;" /> Library Admin</b></span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle Navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-user"></i>
            <span class="hidden-xs"><?php echo htmlspecialchars($user['firstname'].' '.$user['lastname']); ?></span>
          </a>
          <ul class="dropdown-menu">
            <li class="">
              <p>
                <?php echo htmlspecialchars($user['firstname'].' '.$user['lastname']); ?>
                <small>
                  <?php echo ($user['created_on']) ? 'Created on: '.date('M. Y', strtotime($user['created_on'])) : ''; ?>
                </small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="#profile" data-toggle="modal" class="btn btn-default btn-flat" id="admin_profile">Update</a>
              </div>
              <div class="pull-right">
                <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
<?php include 'profile_modal.php'; ?>
