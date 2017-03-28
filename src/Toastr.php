<?php

namespace InCloudOut\Toastr;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Session\SessionManager;

class Toastr
{

    /**
     * Added toasts
     *
     * @var array
     */
    protected $toasts = [];

    /**
     * Illuminate Session
     *
     * @var SessionManager
     */
    protected $session;

    /**
     * Toastr config
     *
     * @var Repository
     */
    protected $config;

    /**
     * Constructor
     *
     * @param SessionManager $session
     * @param Repository $config
     */
    public function __construct(SessionManager $session, Repository $config)
    {
        $this->session = $session;
        $this->config = $config;
    }

    /**
     * Render the toasts' script tag
     *
     * @return string
     * @internal param bool $flashed Whether to get the
     *
     */
    public function execute()
    {
        if($this->config->get('toastr.session'))
        {
            $this->setSessionToasts();
        }

        $toasts = $this->session->get('toastr::toasts');

        if( ! $toasts)
        {
            $toasts = [];
        }

        $output = '<script type="text/javascript">';
        $lastConfig = [];
        foreach($toasts as $notification)
        {
            $config = $this->config->get('toastr.options');

            if(count($notification['options']) > 0)
            {
                // Merge user supplied options with default options
                $config = array_merge($config, $notification['options']);
            }

            // Config persists between toasts
            if($config != $lastConfig)
            {
                $output .= 'toastr.options = ' . json_encode($config) . ';';
                $lastConfig = $config;
            }

            // Toastr output
            $output .= 'toastr.' . $notification['type'] . "('"
                . str_replace("'", "\\'", str_replace(['&lt;', '&gt;'], ['<', '>'], e($notification['message']))) . "'"
                . (isset($notification['title']) ? ", '"
                    . str_replace("'", "\\'", htmlentities($notification['title'])) . "'" : null) . ');';
        }
        $output .= '</script>';

        return $output;
    }

    /**
     * Add a notification
     *
     * @param string $type Could be error, info, success, or warning.
     * @param string $message The notification's message
     * @param string $title The notification's title
     * @param array $options Overrides the default options
     *
     * @return bool Returns whether the notification was successfully added or
     * not.
     */
    public function add($type, $message, $title = null, $options = [])
    {
        $allowedTypes = ['error', 'info', 'success', 'warning'];
        if( ! in_array($type, $allowedTypes))
        {
            return false;
        }

        $this->toasts[] = [
            'type'      => $type,
            'title'     => $title,
            'message'   => $message,
            'options'   => $options
        ];

        $this->session->flash('toastr::toasts', $this->toasts);

        return true;
    }

    /**
     * Shortcut for adding an info notification
     *
     * @param string $message The notification's message
     * @param string $title The notification's title
     * @param array $options Overrides the default options
     */
    public function info($message, $title = null, $options = [])
    {
        $this->add('info', $message, $title, $options);
    }

    /**
     * Shortcut for adding an error notification
     *
     * @param string $message The notification's message
     * @param string $title The notification's title
     * @param array $options Overrides the default options
     *
     * @return void
     */
    public function error($message, $title = null, $options = [])
    {
        $this->add('error', $message, $title, $options);
    }

    /**
     * Shortcut for adding a warning notification
     *
     * @param string $message The notification's message
     * @param string $title The notification's title
     * @param array $options Overrides the default options
     *
     * @return void
     */
    public function warning($message, $title = null, $options = [])
    {
        $this->add('warning', $message, $title, $options);
    }

    /**
     * Shortcut for adding a success notification
     *
     * @param string $message The notification's message
     * @param string $title The notification's title
     * @param array $options Overrides the default options
     *
     * @return void
     */
    public function success($message, $title = null, $options = [])
    {
        $this->add('success', $message, $title, $options);
    }

    /**
     * Clear all toasts
     */
    public function clear()
    {
        $this->toasts = [];
    }

    /**
     * Check session for mapped toasts as defined in config/toastr.php
     */
    private function setSessionToasts()
    {
        foreach ($this->config->get('toastr.maps') as $key => $type)
        {
            if($this->session->has($key))
            {
                list($title, $message, $options) = $this->parseSessionVariables($key);

                $this->add($type, $message, $title, $options);
            }
        }
    }

    /**
     * Used to allow multiple implementation
     *
     * @param $key
     * @return array
     */
    private function parseSessionVariables($key): array
    {
        if(is_array($this->session->get($key)))
        {
            $title = $this->session->get($key)['title'] ?? $this->session->get($key)[0];
            $message = $this->session->get($key)['message'] ?? $this->session->get($key)[1];
            $options = $this->session->get($key)['options'] ?? $this->session->get($key)[2] ?? [];

            return array($title, $message, $options);
        }

        return array(null, $this->session->get($key),[]);
    }
}