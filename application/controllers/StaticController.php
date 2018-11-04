<?php

namespace Icinga\Module\Ckeditor\Controllers;

use Icinga\Exception\NotFoundError;
use Icinga\Web\Controller;

abstract class StaticController extends Controller
{
    /** @var bool Static routes don't require authentication */
    protected $requiresAuthentication = false;

    /**
     * Disable layout rendering as this controller doesn't provide any html layouts
     */
    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
    }

    protected function sendNotFound($message = null)
    {
        try {
            $response = $this->getResponse();
            $response->setHttpResponseCode(404);
            $response->setBody('<h1>Not found</h1>');
            if ($message !== null) {
                $response->appendBody('<p>' . htmlspecialchars($message) . '</p>');
            }
        } catch (\Zend_Controller_Response_Exception $e) {
            // Will not happen.
        }
    }

    protected function sendFile($filePath)
    {
        $this->setCacheHeader();

        $this->getResponse()->setHeader(
            'Last-Modified',
            gmdate('D, d M Y H:i:s', filemtime($filePath)) . ' GMT'
        );

        readfile($filePath);
    }

    /**
     * Set cache header for the response
     *
     * @param int $maxAge The maximum age to set
     */
    protected function setCacheHeader($maxAge = 3600)
    {
        $maxAge = (int) $maxAge;
        $this
            ->getResponse()
            ->setHeader('Cache-Control', sprintf('max-age=%d', $maxAge), true)
            ->setHeader('Pragma', 'cache', true)
            ->setHeader(
                'Expires',
                gmdate('D, d M Y H:i:s', time() + $maxAge) . ' GMT',
                true
            );
    }
}
