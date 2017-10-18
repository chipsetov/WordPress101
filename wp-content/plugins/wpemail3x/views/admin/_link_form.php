<form role="form" method="POST" action="?page=<?= EmailCounter::$name ?>.php">
	<input type="hidden" name="action" value="create_link" id="action">
	<input type="hidden" name="link[id]" value="<?= $this->link->id ?>" id="link_id">
  <div class="form-group">
    <label for="formNameInput">Nombre</label>
    <input class="form-control" id="formNameInput" placeholder="Name" name="link[name]" value="<?= $this->link->name ?>">
  </div>
  <div class="form-group">
    <label for="forActiveInput">Activo URL</label>
    <input class="form-control" id="formActiveInput" placeholder="Active URL" name="link[active_url]" value="<?= $this->link->active_url ?>">
  </div>
  <div class="form-group">
    <label for="formInactiveInput">Inactivo Url</label>
    <input class="form-control" id="formInactiveInput" placeholder="Inactive URL" name="link[inactive_url]" value="<?= $this->link->inactive_url ?>">
  </div>  
  <div class="form-group">
    <label for="formInactiveInput">Mostrador</label>
    <select id="formCounterSelect" class="form-control" name="link[counter_id]">
		<option value="0" <?php if(0 == $this->link->id) echo "checked" ?>>* Seleccione un contador</option>
		<?php foreach(Counter::get_all() as $counter): ?>
			<option value="<?= $counter->id ?>" <?php if($counter->id == $this->link->counter_id) echo "selected" ?>><?= $counter->name ?></option>
		<?php endforeach; ?>
	</select>
  </div>    
  <button type="submit" class="btn btn-primary">Enviar</button>
  <button type="button" name="cancel_button" class="btn btn-default">Cancelar</button>
</form>
