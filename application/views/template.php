<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if(!isset($active)){
    $active = 'Menu';
    $this->load->view('header',$active);
} else {
    $this->load->view('header',$active);
}
//$this->load->view('header',$active);
$this->load->view($middle);
$this->load->view('footer');
?>