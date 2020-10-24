<?php
class Main extends Model
{

	function __construct()
	{
		$this->view = new View();
	}

	public function get_data($page=null,$offset=null,$limit=null,$sort=null,$column=null)
	{	$db = new db();
		return $db->select("tasks", $page,$offset,$limit,$sort,$column);
	}

	public function get($id)
	{	$db = new db();
		return $db->get("tasks", $id);
	}

	public function add_data($data)
	{	$db = new db();
		return $db->add("tasks", $data);
	}

	public function update_data($data,$id)
	{	$db = new db();
		return $db->update("tasks", $data, $id);
	}
	
	public function change_status($data)
	{	
		$db = new db();
		return $db->update_status("tasks", $data);
	}

}

?>