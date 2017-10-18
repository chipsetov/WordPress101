<link rel="stylesheet" href="<?=plugin_dir_url( __FILE__ ) ?>../../include_files/css/DateTimePicker.css">
<script src="<?=plugin_dir_url( __FILE__ ) ?>../../include_files/js/DateTimePicker.js"></script>
<style type="text/css" media="screen">
	#banner_selector img{
		width:200px;
	}
	#banner_selector td {
	    border: none;
	}
</style>
<h2 class="space"><small>Paso 1: Configuración del contador</small></h2>
<form role="form" method="POST" action="?page=<?= EmailCounter::$name ?>.php">
	<input type="hidden" name="action" value="create" id="action">
	<input type="hidden" name="counter[id]" value="<?= $this->counter->id ?>" id="counter_id">
  <div class="form-group numbers-style">
    <label for="formNameInput">Nombre del contador</label>
    <input class="form-control" id="formNameInput" placeholder="Nombre" name="counter[name]" value="<?= $this->counter->name ?>">
  </div>
  <div class="form-group numbers-style">
    <label for="formWidthInput">Ancho de imagen del contador <small>(Para correo electrónico)</small></label>
    <input class="form-control" id="formWidthInput" placeholder="Anchura" name="counter[width]" value="<?= $this->counter->width ?>">
  </div>  
  <div class="form-group numbers-style">
    <label for="formTimezoneInput">Selecciona la zona horaria</label>
	<select class="form-control" id="formTimezoneInput" name="counter[timezone]">
		<?php foreach(AppCore::get_timezones() as $timezone): ?>
			<option value="<?php echo $timezone; ?>" <?php if($this->counter->timezone == $timezone) echo 'selected="select"' ?>><?php echo $timezone; ?></option>
		<?php endforeach; ?>
	</select>
  </div>
  <div class="form-group form-inline position-elem">
    <label for="exampleInputDate">Seleccione Fecha de finalización</label>
    <input type="text" class="form-control" id="endDateInput" name="counter[end_date]" value="<?= $this->counter->pretty_date() ?>">
	 <div id="dtBox"></div>
  </div>
  <div class="form-group form-inline position-elem">
   <label for="exampleInputTime">Seleccione Hora de finalización</label>
	<input type="text" class="form-control" id="endTimeInput" name="counter[end_time]" data-field="time" value="<?= $this->counter->end_time ?>">
  </div>

  <h2><small>Paso 2: Configuración del vínculo (Opcional)</small></h2>
  <?php if(is_object($this->counter->link) && isset($this->counter->link->id)): ?>
	  <input type="hidden" name="link[id]" value="<?= $this->counter->link->id ?>" id="link_id">
  <?php endif; ?>
  <div class="form-group urls-align">
    <label for="formNameInput">Nombre del enlace <small>(Uso interno)</small></label>
    <input class="form-control" id="formNameInput" placeholder="Nombre" name="link[name]" value="<? if(is_object($this->counter->link)) echo $this->counter->link->name ?>">
  </div>
  <div class="form-group urls-align">
    <label for="forActiveInput">Activo URL <small>(Antes del vencimiento)</small></label>
    <input class="form-control" id="formActiveInput" placeholder="Activo URL" name="link[active_url]" value="<? if(is_object($this->counter->link)) echo $this->counter->link->active_url ?>">
  </div>
  <div class="form-group urls-align">
    <label for="formInactiveInput">Caducado URL <small>(Después de que el tiempo se acabe)</small></label>
    <input class="form-control" id="formInactiveInput" placeholder="Caducado URL" name="link[inactive_url]" value="<? if(is_object($this->counter->link)) echo  $this->counter->link->inactive_url ?>">
  </div>  
  
  
  <h2><small>Paso 3: Elija el estilo del contador</small></h2>
  <label for="banner">Estilo de contador activo</label>
  <div id="banner_selector" class="form-group">
	  <div class="table borderless" id="main-table">
<?php foreach(Banner::get_all() as $banner): ?>
		  <div class="top-item">
			  <input type="radio" name="counter[template]" value="<?php echo $banner->name() ?>" <?php if( $this->counter->banner && $banner->name() == $this->counter->banner->name()): ?> checked <?php endif; ?>
                  <?php if($_GET['action'] == 'new')echo 'checked'; ?>>
		  	  <img src="<?php echo $banner->preview_url(); ?>" />
          </div>
<?php endforeach; ?>
	</div>
  </div>
  
  <label for="banner">Estilo de contador caducado</label>
  <div id="banner_selector" class="form-group">
	  <div id="main-table">
	  <?php $i = 0; foreach(Expired::get_all() as $expired_image): $i++; ?>
		  <div class="botton-item">
			  <input type="radio" name="counter[expired]" value="<?php echo $expired_image->name() ?>" <?php if($this->counter->expired && $expired_image->name() == $this->counter->expired_image->name()): ?> checked <?php endif; ?>
                  <?php if($_GET['action'] == 'new')echo 'checked'; ?>>
              <img src="<?php echo $expired_image->preview_url() ?>" />
          </div>
	<?php endforeach; ?>
	</div>
  </div>
  <div class="form-group">
  <button type="submit" class="btn btn-primary">Salvar</button>
  <button type="button" name="cancel_button" class="btn btn-default">Cancelar</button>
	</div>
</form>
<style>
    .form-inline .form-control{
        font-size: 24px;
        color: grey;
        text-align: center;
    }
    .position-elem{width:49.8%; display: inline-block; background: #c2e1fd !important;}
    .dtpicker-buttonCont .dtpicker-button{
        width: 65px;
        height: 65px;
        padding: 1.6em 0em;
        border-radius: 100%;
    }
    .dtpicker-bg{background-image: url("include_files/minlogo.png");}
    .dtpicker-header .dtpicker-value {
        padding: 0.8em 0.2em 0.2em 0.2em;
        color: #FF3B30;
        text-align: center;
        font-size: 8em;
        font-weight: bold;
     }
    .urls-align{width:33%; display: inline-block; margin: 30px 0;}
    .dtpicker-header .dtpicker-title {
        color: #d0cccd;
        text-align: center;
        font-size: 26px;
        text-transform: uppercase;
        margin: 45px;
        margin-top: -150px;
    }
    .top-item{
        display: inline-block;
        width: 33.1%;
        margin-top: 25px;
        text-align: center;
        background: lightslategrey;
        padding: 30px;
        -webkit-transition: all 500ms ease;
        -moz-transition: all 500ms ease;
        -ms-transition: all 500ms ease;
        -o-transition: all 500ms ease;
        transition: all 500ms ease;
    }
    .space{
        margin: 40px 0;
    }
    #formTimezoneInput{
        height: 50px;
        padding-left: 30px;
    }
    .form-control{height: 50px; border-radius:50px; text-align: center; font-weight: bold;}
.dtpicker-components .dtpicker-comp > *{
    font-size: 35px !important;
}
    .dtpicker-components{margin-top: 55px;}
h2 small{
    text-transform: uppercase; color: #3e0b0b;}
label{font-size: 15px;}
.numbers-style{width:33.1%; display: inline-block; background: #e5ebf1 !important;}
.botton-item{
    display: inline-block;
    width: 33.1%;
    text-align: center;
    background: lightslategrey;
    padding: 30px;
    -webkit-transition: all 500ms ease;
    -moz-transition: all 500ms ease;
    -ms-transition: all 500ms ease;
    -o-transition: all 500ms ease;
    transition: all 500ms ease;
}
.top-item:hover, .botton-item:hover{
    background: #f1f1f1;
    -webkit-transition: all 500ms ease;
    -moz-transition: all 500ms ease;
    -ms-transition: all 500ms ease;
    -o-transition: all 500ms ease;
    transition: all 500ms ease;
}
input[type="radio"]{
    height: 30px;
    width: 30px;
}
#banner_selector{
    background-color: lightgrey;
    padding: 15px 15px;
}
input[type=radio]:checked:before{
    content: "\2022";
    text-indent: -9999px;
    -webkit-border-radius: 50px;
    border-radius: 50px;
    font-size: 33px;
    width: 18px;
    height: 18px;
    margin: 5px;
    background-color: #1e8cbe;
}
    .dtpicker-content{border-radius: 100%;}
.dtpicker-subcontent{margin-top: 88px;}

.form-group{
    background: #eaeaea;
    padding: 20px;
}
    .dtpicker-buttonCont {
        overflow: hidden;
        margin: 0.2em 1em;
        width: 64%;
        margin: 0 auto;
    }
    #logo{
        text-align: center;
    }
    #shortlink{color: #fff; font-size:15px;
        font-weight:bold; text-align: center;}
code {
    padding: 20px 20px;
    font-size: 134%;
    color: #000;
    /*background-color: #561729;*/
    border-radius: 4px;
    width:100%;
    margin-top: 20px;
  /*  float: right;
    margin-top: -41px;*/
}
h1 small{color: #561729; text-transform: uppercase; font-size:18px; padding-left: 20px;}
.dtpicker-bg{
        -webkit-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        border: none;
        margin: 0 auto !important;
        margin-top: 450px !important;
        background: #fff !important;
        width: 600px !important;
        height: 600px !important;
        border-radius: 100% !important;
    }
    @media screen and (max-width: 1550px) {
        code {
            padding: 0;
        }
    }
@media screen and (max-width: 850px) {
    .top-item{display: block; width: 100%; margin-top: 25px; text-align: center;}
    .botton-item{display: block; width: 100%; text-align: center;}
    .numbers-style, .urls-align, .position-elem{width:100%;}
    code{padding: 5px; font-size: 103%;}
}
</style>

<script type="text/javascript">
	$( "#endDateInput" ).datepicker();
	$("#dtBox").DateTimePicker();
</script>