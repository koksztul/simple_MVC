<?php

namespace App\Controllers;

use App\TwigWrapper;
use Twig\Environment;

class Controller
{
    public Environment $twig;

    /**
     * render
     *
     * @param  string $view
     * @param  array $data
     * @return void
     */
    protected function render(string $view, array $data = []): void
    {
        $this->twig = (new TwigWrapper())();
        $template = $this->twig->load($view . '.twig');
        echo $template->render($data);
    }
}
