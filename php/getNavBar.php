<?php
function getNavBar(){
	$logincookie = true;
	if($logincookie == false) {
		echo '<nav class="navbar navbar-expand navbar-inverse navbar-fixed-top">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#MyNavbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
						<a class="navbar-brand" href="#"><img src="../img/garage_logo_final2.jpg" /></a>
					</div>
					<div class="collapse navbar-collapse" id="MyNavbar">
						<ul class="nav navbar-nav navbar float-left">
							<li class="active">
								<a href="#">Home</a>
							</li>
							<li role="separator" class="divider"></li>
							<li><a href="">Sales</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="">Items</a></li>
							<li role="separator" class="divider"></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="#">
									<form class="navbar-form navbar-right" role="search">
										<div class="input-group">
											<input id="search" type="text" class="form-control" placeholder="Search" name="search">
											<div class="input-group-btn">
												<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
											</div>
										</div>
									</form>
								</a>
							</li>
							<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
						</ul>
					</div>
				</div>
			</nav>';
	}
	if($logincookie == true) {
		echo '<nav class="navbar navbar-expand navbar-inverse navbar-fixed-top">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#MyNavbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
						<a class="navbar-brand" href="#"><img src="../img/garage_logo_final2.jpg" /></a>
					</div>
					<div class="collapse navbar-collapse" id="MyNavbar">
						<ul class="nav navbar-nav navbar float-left">
							<li class="active">
								<a href="#">Home</a>
							</li>
							<li role="separator" class="divider"></li>
							<li><a href="">Sales</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="">Items</a></li>
							<li role="separator" class="divider"></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="#">
									<form class="navbar-form navbar-right" role="search">
										<div class="input-group">
											<input id="search" type="text" class="form-control" placeholder="Search" name="search">
											<div class="input-group-btn">
												<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
											</div>
										</div>
									</form>
								</a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="#">My Sales</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="#">My Items</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="#">Prefered Items</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="#">One more separated link</a></li>
								</ul>
							</li>
							<li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						</ul>
					</div>
				</div>
			</nav>';
		}
	}
?>
