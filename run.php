<?php

/** @var $this Icinga\Application\Modules\Module */
$this->addRoute(
    'vendor_ckeditor',
    new Zend_Controller_Router_Route_Regex('ckeditor/vendor/(.+)', [
        'module'     => 'ckeditor',
        'controller' => 'vendor',
        'action'     => 'index'
    ], [
        1 => 'file'
    ], 'ckeditor/vendor/%s')
);
