<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>clueTip Plugin Demo</title>
  
  <base href="<?php echo $this->config->item('base_url') ?>/www/demo"/>
  
  <link rel="stylesheet" href="../jquery.cluetip.css" type="text/css" />
  <link rel="stylesheet" href="demo.css" type="text/css" /></head> 
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
  <script src="<?php echo $this->config->item('base_url') ?>/www/lib/jquery.hoverIntent.js" type="text/javascript"></script>
  <script src="<?php echo $this->config->item('base_url') ?>/www/lib/jquery.bgiframe.min.js" type="text/javascript"></script>
  <script src="<?php echo $this->config->item('base_url') ?>/www/jquery.cluetip.js" type="text/javascript"></script>
  <script src="<?php echo $this->config->item('base_url') ?>/www/demo/demo.js" type="text/javascript"></script>
<body>
<a class="custom-width" href="" rel="<?php echo site_url('client/tooltips/1234');?>">try me</a>
<a class="custom-width" href="" rel="<?php echo site_url('client/tooltips/3456');?>">try me two</a>
</body>
</head>