<?php

namespace Icinga\Module\Ckeditor\Controllers;

class VendorController extends StaticController
{
    public function indexAction()
    {
        $file = $this->_getParam('file');
        if (! preg_match('/^[A-z0-9_\/\-\.]+\.(js|css|png|gif)$/', $file, $match) || strpos($file, '..') !== false) {
            $this->sendNotFound();
            return;
        }
        $extension = $match[1];
        $contentTypes = [
            'js' => 'text/javascript',
            'css' => 'text/css',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ];

        $filePath = $this->Module()->getBaseDir() . '/public/js/vendor/ckeditor/' . $file;

        if (! file_exists($filePath)) {
            $this->sendNotFound();
            return;
        }

        $response = $this->getResponse();
        $response->setHeader('Content-Type', $contentTypes[$extension]);
        $this->sendFile($filePath);
    }
}
