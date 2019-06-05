<?php

namespace App\Session;

use Illuminate\Session\Store;

class FlashMessage
{
    /**
     * @var Store
     */
    protected $session;

    /**
     * @param Store $session
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
}
