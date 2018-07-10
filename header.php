<style>
  nav.navbar-findcond { background: #fff; border-color: #ccc; box-shadow: 0 0 2px 0 #ccc; }
  nav.navbar-findcond a { color: #f14444; }
  nav.navbar-findcond ul.navbar-nav a { color: #f14444; border-style: solid; border-width: 0 0 2px 0; border-color: #fff; }
  nav.navbar-findcond ul.navbar-nav a:hover,
  nav.navbar-findcond ul.navbar-nav a:visited,
  nav.navbar-findcond ul.navbar-nav a:focus,
  nav.navbar-findcond ul.navbar-nav a:active { background: #fff; }
  nav.navbar-findcond ul.navbar-nav a:hover { border-color: #f14444; }
  nav.navbar-findcond li.divider { background: #ccc; }
  nav.navbar-findcond button.navbar-toggle { background: #f14444; border-radius: 2px; }
  nav.navbar-findcond button.navbar-toggle:hover { background: #999; }
  nav.navbar-findcond button.navbar-toggle > span.icon-bar { background: #fff; }
  nav.navbar-findcond ul.dropdown-menu { border: 0; background: #fff; border-radius: 4px; margin: 4px 0; box-shadow: 0 0 4px 0 #ccc; }
  nav.navbar-findcond ul.dropdown-menu > li > a { color: #444; }
  nav.navbar-findcond ul.dropdown-menu > li > a:hover { background: #f14444; color: #fff; }
  nav.navbar-findcond span.badge { background: #f14444; font-weight: normal; font-size: 11px; margin: 0 4px; }
  nav.navbar-findcond span.badge.new { background: rgba(255, 0, 0, 0.8); color: #fff; }
</style>

<nav class="navbar navbar-findcond navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">
      	<i class="glyphicon glyphicon-knight" aria-hidden="true"></i>
        <b>Staff</b><i>ing</i> <b>Monitoring System</b>
      </a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-fw fa-bell-o"></i> Bildirimler <span class="badge">0</span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#"><i class="fa fa-fw fa-tag"></i> <span class="badge">Music</span> sayfası <span class="badge">Video</span> sayfasında etiketlendi</a></li>
            <li><a href="#"><i class="fa fa-fw fa-thumbs-o-up"></i> <span class="badge">Music</span> sayfasında iletiniz beğenildi</a></li>
            <li><a href="#"><i class="fa fa-fw fa-thumbs-o-up"></i> <span class="badge">Video</span> sayfasında iletiniz beğenildi</a></li>
            <li><a href="#"><i class="fa fa-fw fa-thumbs-o-up"></i> <span class="badge">Game</span> sayfasında iletiniz beğenildi</a></li>
          </ul>
        </li> -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Staff Request <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="index.php"><span class="glyphicon glyphicon-list"></span> Staff Request List</a></li>  
            <li><a href="index.php?mn=2"><span class="glyphicon glyphicon-plus-sign"></span> Add Staff Request</a></li>  
          </ul>
        </li>
        <li class="active"><a href="index.php?mn=4"><span class="glyphicon glyphicon-screenshot"></span> Talent Pool <span class="sr-only">(current)</span></a></li>
        <li class="active"><a href="index.php?mn=5"><span class="glyphicon glyphicon-list"></span> Candidates <span class="sr-only">(current)</span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><b>Welcome, <?php echo $_SESSION["user"] ?> </b> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>  
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>