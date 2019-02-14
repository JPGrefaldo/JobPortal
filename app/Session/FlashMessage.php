<?php

namespace App\Session;

use Illuminate\Session\Store;

class FlashMessage
{
    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;

    /**
     * @param \Illuminate\Session\Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * @param string $message
     * @param string $title
     */
    public function error($message, $title = '')
    {
        $this->flash($message, $title, "error");
    }

    /**
     * @param string $message
     * @param string $title
     */
    public function info($message, $title = '')
    {
        $this->flash($message, $title, "info");
    }

    /**
     * @param string $message
     * @param string $title
     */
    public function success($message, $title = '')
    {
        $this->flash($message, $title, "success");
    }

    /**
     * @param string $message
     * @param string $title
     */
    public function warning($message, $title = '')
    {
        $this->flash($message, $title, "warning");
    }

    /**
     * @param string $title
     * @param string $message
     * @param string $type
     */
    private function flash($message, $title, $type)
    {
        $this->session->flash('flash_message', $message);
        $this->session->flash('flash_title', $title);
        $this->session->flash('flash_type', $type);
    }
}
