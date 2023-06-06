<?php $session = session();?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?=base_url()?>/apis/movie">Home</a>
        </li>
        <li class="nav-item">
		  <?php
			if($session->get('logged_in') == null)
				echo("<a class=\"nav-link\" href=\"".base_url()."/login\">Login</a>");
			else{
				echo("<a class=\"nav-link\" href=\"".base_url()."/logout\">Logout</a>");
			}
		  ?>
		</li>
		  <?php
			if($session->get('logged_in') == null)
				echo("");
			else{
				echo("
				<li class=\"nav-item dropdown\">
				  <a class=\"nav-link dropdown-toggle\" href=\"#\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">".
					$session->get('username')."
				  </a>
				  <ul class=\"dropdown-menu\">
					<li><a class=\"dropdown-item\" href=\"#\">Action</a></li>
					<li><a class=\"dropdown-item\" href=\"#\">Another action</a></li>
					<li><hr class=\"dropdown-divider\"></li>
					<li><a class=\"dropdown-item\" href=\"#\">Something else here</a></li>
				  </ul>
				</li>");
			}
		  ?>
        <li class="nav-item">
          <a class="nav-link" href="<?=base_url()?>/map" >Map</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-light" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>