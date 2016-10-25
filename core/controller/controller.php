<?php

namespace Core\Controller;

/**
 * Parent Controller
 */
class Controller
{

    protected $viewPath;
    protected $template;

    protected function render($view, $variables = [])
    {
        ob_start();
        extract($variables);
        $view    = require $this->viewPath . str_replace('.', '/', $view) . '.php';
        $content = ob_get_clean();
        require $this->viewPath . 'templates/'.$this->template . '.php';
    }

    /**
     * Thow error page
     */
    protected function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        header('location:index.php?p=404');
    }

    /**
     * Display message if user is not allowed in
     */
    protected function forbiden()
    {
        header('HTTP/1.0 403 Not Found');
        die('acces interdit');
    }

}
