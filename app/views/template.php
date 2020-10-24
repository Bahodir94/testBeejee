<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Главная</title>
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css" />
	<script type="text/javascript" src="/assets/js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  		<a class="navbar-brand" href="#">TEST</a>
	  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#testnav" aria-controls="testnav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
	  	</button>
	  	<div class="collapse navbar-collapse" id="testnav">
		    <ul class="navbar-nav ml-auto">
		      	<li class="nav-item active">
			        <a class="nav-link" href="/main/index">Главная <span class="sr-only">(current)</span></a>
		      	</li>
				<li class="nav-item">
					<a class="nav-link" href="/main/add">Добавить задача</a>
				</li>
				<?php if($_SESSION['user']!='admin') : ?>
			      	<li class="nav-item">
			        	<a class="nav-link" href="/main/login">Авторизация</a>
			      	</li>
		      	<?php endif ?>
				<?php if($_SESSION['user']=='admin') : ?>
			      	<li class="nav-item">
			      		<form method="post" action="/main">
			      			<input type="submit" name="logout" class="btn btn-link" value="Выход">
		        		</form>
			      	</li>
		      	<?php endif ?>
		    </ul>
	  	</div>
	</nav>
	<main role="main" class="container mt-5">
		<?php if ($_SESSION['success'] || $_SESSION['error']){
			if(!empty($_SESSION['success'])) {
				$css = "success";
				$text = $_SESSION['success'];
			}
			else {
				$css = 'danger';
				$text = $_SESSION['error'];
			}
		?>
			<div class="alert alert-<?=$css?> alert-dismissible fade show" role="alert">
			  <strong><?=$text?></strong>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
		<?php 
			unset($_SESSION['success']);
			unset($_SESSION['error']);
		}
		?>
	  <div class="card shadow pl-5 pr-5 pt-2 pb-2 mb-5 bg-white rounded">
			<?php include 'app/views/'.$content_view; ?>
	  </div>

	</main>
</body>
</html>
