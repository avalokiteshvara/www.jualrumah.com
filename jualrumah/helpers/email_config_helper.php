<?php

function email_conf(){

	 $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => '3mail.h4ck3r@gmail.com',
        'smtp_pass' => '1n1emailhacker',
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE
    );

	 return $config;
}
