<?php  
	$url = "/main/index?";
    $page = $data['page'];
    $number_of_pages = $data['number_of_pages'];
?>
<div class="row table-responsive">	
	<h1>Тестовое задание</h1>
	<table class="table table-border table-strip table-hover">
		<thead>
			<th>
				<label class="sort" data-column="id">ID</label>
				<img src="/assets/img/<?=($params['sort'] && $params['column'] =='id') ? $params['sort'] : "desc"?>.png" height='20px'>
			</th>
			<th>
				<label class="sort" data-column="username">Имя</label>
				<img src="/assets/img/<?= ($params['sort'] && $params['column'] =='username') ? $params['sort'] : "desc"?>.png" height='20px'>
			</th>
			<th>
				<label class="sort" data-column="email">Email</label>
				<img src="/assets/img/<?=($params['sort'] && $params['column'] =='email') ? $params['sort'] : "desc"?>.png" height='20px'>
			</th>
			<th>Текст</th>
			<th>
				<label class="sort" data-column="status">Статус</label>
				<img src="/assets/img/<?=($params['sort'] && $params['column'] =='status') ? $params['sort'] : "desc"?>.png" height='20px'>
			</th>
			<?php if($_SESSION['user']=='admin'){ ?>
				<th colspan="2">
					Управления
				</th>
			<?php } ?>
		</thead>
		<tbody>
			<?php foreach($data['result'] as $row): ?> 
				<tr>
					<td><?=$row['id'];?></td>
					<td><?=$row['username'];?></td>
					<td><?=$row['email'];?></td>
					<td><?=$row['task_description'];?></td>
					<td><?=($row['status'] == 0) ?  "Не выполнено" : "Выполнено";?><?=($row['edited'] ==1) ? "<br><small><i>(отредактировано администратором)</i></small>":""?></td>
					<?php if($_SESSION['user']=='admin') : ?>
						<td>
						<?php if ($row['status']==0) :?>
							<button type="button" data-id="<?=$row['id']?>" class="status-done btn btn-success">Отметить как выполнено</button>
						<?php endif ?>
						<?php if ($row['status']==1) :?>
							<button type="button" data-id="<?=$row['id']?>" class="status-undone btn btn-info">Отметить как невыполнено</button>
						<?php endif ?>
						</td>
					<td><a href="/main/update?id=<?=$row['id'];?>">Редактировать</a></td>
					<?php endif ?>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php if ($number_of_pages > 1): ?>
	<nav aria-label="Page navigation">
	  <ul class="pagination">
	  	<?php if ($page): ?>
		    <li class="page-item">
				<?php $url = "/main/index?"; ?>
	    		<?php if (!empty($params['page']) || empty($params['page'])) { $params['page'] = 1; $url.=  http_build_query($params); }?>
		      <a class="page-link" href="<?=$url?>" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		        <span class="sr-only">Previous</span>
		      </a>
		    </li>
		<?php endif ?>
		<?php for ($i=1;$i<=$number_of_pages;$i++) : 
			$url = "/main/index?";
		?>
			<?php if (!empty($params['page']) || empty($params['page'])) { $params['page'] = $i; $url.=  http_build_query($params); } ?>
	    	<li class='page-item <?=($i==$_GET['page']||($i==1&&empty($_GET['page'])))? "active":""?>'><a class="page-link" href="<?=$url?>"><?=$i?></a></li>
		<?php endfor ?>
	    <li class="page-item">
	     <?php if (($page + 1) != $number_of_pages) :?>
			<?php  
				$url = "/main/index?"; 
				if (!empty($params['page']) || empty($params['page'])) { $params['page'] = $number_of_pages; $url.=  http_build_query($params); } 
			?>
	      <a class="page-link" href="<?=$url?>" aria-label="Next">
	        <span aria-hidden="true">&raquo;</span>
	        <span class="sr-only">Next</span>
	      </a>
	  	<?php endif ?>
	    </li>
	  </ul>
	</nav>
	<?php endif ?>
</div>
<script type="text/javascript">
	var url = new URLSearchParams(location.search);
	var http = '/main/index?'+ url;
	$(".sort").click(function()
	{
		var sort = this.dataset.sort; 
		var column = this.dataset.column;
		var img;
		sortUrl = url.get('sort');
		columnUrl = url.get('column');
		if (sortUrl == 'asc')  { sort = 'desc';}
		else if (sortUrl = 'desc') { sort = 'asc';}
		this.dataset.sort = sort;
		this.append(img);
		url.set('sort', sort);
		url.set('column', column);

		window.location = '/main/index?'+url;
	});

	$(".status-done").click(function()
	{
		var id = this.dataset.id;
		var dat = {'status' : 1, 'id' : id };
		$.ajax({ 
		  url: "/main/statusupdate", 
		   	method: "POST", 
		   	data: {status: dat},
		   	success: function(data) {
				window.location.reload();
		   }
		});
	});

	$(".status-undone").click(function()
	{
		var id = this.dataset.id;
		var dat = {'status' : 0, 'id' : id };
		$.ajax({ 
		  url: "/main/statusupdate", 
		   	method: "POST", 
		   	data: {status: dat},
		   	success: function(data) {
				window.location.reload();
		   }
		});
	});
</script>
