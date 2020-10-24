<div class="form-group">
	<h1>Редактировать задача</h1>
</div>
<form method="post">
	<div class="row">
		<div class="form-group col-md-5">
			<label for="username">Имя:</label>
			<input type="text" name="username" id="username" class="form-control" placeholder="Введите имя" required="true" value="<?=$data['username'];?>">
		</div>
		<div class="form-group col-md-5">
			<label for="email">Email:</label>
			<input type="email" name="email" class="form-control" placeholder="Введите e-mail" required="true" value="<?=$data['email']?>">
		</div>
	</div>

	<div class="row">
		<div class="col-md-10">
			<label for="task_description">Текст:</label>
			<textarea class="form-control" name="task_description" id="task_description" rows="6" required="true"><?=$data['task_description']?></textarea>
		</div>
	</div>
	<br/>
	<input type="submit" name="save" value="Сохранить" class="btn btn-success">
</form>
