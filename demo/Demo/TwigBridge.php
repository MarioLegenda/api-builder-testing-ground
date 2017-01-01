<?php

namespace Demo;

require_once __DIR__.'/../../vendor/twig/twig/lib/Twig/Autoloader.php';

class TwigBridge
{
    /**
     * @var \Twig_Environment $twig
     */
    private $twig;

    public function __construct()
    {
        \Twig_Autoloader::register();

        $loader = new \Twig_Loader_Filesystem(__DIR__.'/templates');
        $twig = new \Twig_Environment($loader, array(
            'cache' => false,
            'strict_variables' => true,
        ));

        $this->twig = $twig;
    }
    /**
     * @return \Twig_Environment
     */
    public function getTwig() : \Twig_Environment
    {
        return $this->twig;
    }
}