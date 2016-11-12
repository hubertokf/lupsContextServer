
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title;?></title>

	<link type="text/css" rel="stylesheet"  media="screen" href="<?php echo base_url()?>css/chosen.css" />
	<link type="text/css" rel="stylesheet"  media="screen" href="<?php echo base_url()?>css/jquery-ui-timepicker-addon.css" />
	<link type="text/css" rel="stylesheet"  media="screen" href="<?php echo base_url()?>css/bootstrap.min.css" >
	<link type="text/css" rel="stylesheet"  media="screen" href="<?php echo base_url()?>css/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet"  media="screen" href="<?php echo base_url()?>css/principal.css" />
	<link type="text/css" rel="stylesheet"  media="screen" href="<?php echo base_url()?>css/extra.css" />
  <link type="text/css" rel="stylesheet"  media="screen" href="<?php echo base_url()?>css/jquery-ui.css">
  <link type="text/css" rel="stylesheet"  media="screen" href="<?php echo base_url()?>css/dataTables.fontAwesome.css">
	<link href="<?php echo base_url()?>css/main.css" rel="stylesheet">
  <link href="<?php echo base_url()?>css/aquisition.css" rel="stylesheet">

    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery-ui.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/chosen.jquery.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/calendar.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery.xdomainajax.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery.numeric.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery.mask.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/highstock/highstock.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/highstock/exporting.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/helper.js"></script>
    <script>
        window.base_url = <?php echo json_encode(base_url()); ?>;
    </script>

</head>
<body>

    <?php
    $usuario_id = $this->session->userdata('usuario_id');
    if ($this->session->userdata('usuario_id') != null && $this->M_usuarios->selecionar($usuario_id)->result_array()[0]["img_cabecalho"] != "")
        $file = $this->M_usuarios->selecionar($usuario_id)->result_array()[0]["img_cabecalho"];
    else
        $file = $this->M_configuracoes->selecionar('img_cabecalho')->result_array()[0]["value"];
    ?>
	<section class="header container-fluid" style="background-color: #142b55; background: url(<?php echo base_url()?>uploads/<?php echo $file?>) center; background-size: cover; background-position: 0px -180px;">
    	<div class="headermask"></div><!-- /.headermask -->
        <div class="container">
            <div class="invisiblemenu row">
                <div class="col-xs-8">
                    <div class="projectName">
                        <?php 
                            if ($this->session->userdata('usuario_id') != null && $this->M_usuarios->selecionar($usuario_id)->result_array()[0]["titulo_projeto"] != "")
                                echo $this->M_usuarios->selecionar($usuario_id)->result_array()[0]["titulo_projeto"];
                            else
                                echo $this->M_configuracoes->selecionar('titulo_projeto')->result_array()[0]["value"];
                        ?>
                    </div>
                    <div class="app <?php if ($this->uri->segment(1) == 'CI_visualizacao' || $this->uri->segment(1) == '') echo 'ativo'; ?>">
                        <a href="<?php echo base_url(); ?>CI_visualizacao">Visualizacão</a>
                    </div>

                    <?php
                    if ($isLoged != ""){
                    ?>

                    <div class="app <?php if ($this->uri->segment(1) != 'CI_visualizacao') echo 'ativo'; ?>">
                        <a href="<?php echo base_url(); ?>CI_inicio">Gerenciamento</a>
                    </div>

                    <?php } ?>
                </div>
                <div class="session col-xs-4">
                    <?php if ($isLoged == "" || $isLoged == "0"){ ?>
                        <div class="logar">
                            <a href="<?php echo base_url(); ?>CI_login" style="padding:0;">Logar-se</a>
                        </div>
                    <?php } else { ?>
                        <div class="usuariologado">
                            <i class="fa fa-user fa-lg"></i>
                            <?php echo $usuario_logado; ?>
                        </div>
                        <div class="logout">
                            <a href="<?php echo base_url(); ?>CI_login/deslogar">Sair</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="out-content row">
                <div class="col-sm-9" style="height: 110px;">
                	<div class="content" style="text-align:left;">
                		<a href="<?php echo base_url(); ?>CI_visualizacao">
	                        <h1 id="title"><?php echo $this->dados['title']; ?></h1>
	                    </a>
                	</div>
                </div>

                <div class="col-sm-3" >
                    <div class="logo" style="text-align: center;">
                        <?php
                        if ($this->session->userdata('usuario_id') != null && $this->M_usuarios->selecionar($usuario_id)->result_array()[0]["img_projeto"] != "")
                            $file = $this->M_usuarios->selecionar($usuario_id)->result_array()[0]["img_projeto"];
                        else
                            $file = $this->M_configuracoes->selecionar('img_projeto')->result_array()[0]["value"];
                        ?>
                        <img src="<?php echo base_url()?>uploads/<?php echo $file?>" />

                    </div>
                </div>
            </div>
        </div>
    </section>



<div class="geral">
