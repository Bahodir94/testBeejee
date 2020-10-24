<?php
session_start();

class MainController extends Controller
{

	function __construct()
	{
		$this->model = new Main();
		$this->view = new View();
	}

	function index()
	{	
		if (isset($_POST['logout']))
		{
			session_start();
			$_SESSION['user']='guest';
		}

		

		$limit = 3;
		if (isset($_GET['page'])) 
		{
		    $page = $_GET['page'] - 1;
		    $offset = $page * $limit;
		} 
		else 
		{
		    $page = 0; 
		    $offset = 0;
		}
		if (isset($_GET))
		{
			$params = $_GET;
			if (isset($_GET['sort']))
			{
				$sort = $_GET['sort'];
				$column = $_GET['column'];
			}
		}
		if (isset($sort) && isset($column)) 
			$tasks = $this->model->get_data($page,$offset,$limit,$sort,$column);
		else	
			$tasks = $this->model->get_data($page,$offset,$limit);		

		$this->view->generate('index.php', $tasks, $params);
	}
	
	function statusUpdate(){
		if (isset($_POST['status'])){
			$data = json_encode($_POST['status']);
			$data = json_decode($data, true);
			$this->model->change_status($data);
		}
	}

	function add()
	{	
		if (isset($_POST) && $_POST['save'])
		{
			if ($this->model->add_data($_POST)) 
			{ 
				$_SESSION['success'] = "Задача успешно добавлено!";
				echo '<script>window.location="/main/index"</script>';
			}
		}
		else 
		{
			$this->view->generate('add.php');
		}
	}
	
	function update()
	{	
		session_start();
		if ($_SESSION['user']=='guest'){
			header("location: /main/login");
		}
		if (isset($_GET['id']) && !empty($_GET['id']))
		{
			$task = $this->model->get($_GET['id']);
			$this->view->generate('update.php',	mysqli_fetch_assoc($task));

			if (isset($_POST) && $_POST['save'])
			{
				if ($this->model->update_data($_POST, $_GET['id'])) {
					$_SESSION['success'] = "Задача успешно отредактировано!";
					echo '<script>window.location="/main/index"</script>';
				}
			}
		}
	}
	
	function login()
	{	
		if (isset($_POST) && !empty($_POST))
		{
			if ($_POST['username'] == 'admin' && $_POST['password'] =='123') : 
				$_SESSION['user'] = 'admin';
				$_SESSION['success'] = "Вы успешно авторизавано!";
				echo '<script>window.location="/main/index"</script>';
			else:
				$_SESSION['error'] = "Неверное имя пользователя или пароль!";
			endif;
		}	
		$this->view->generate('login.php', $tasks);
	}
}

?>