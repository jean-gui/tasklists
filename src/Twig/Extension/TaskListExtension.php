<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TaskListExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('preg_replace', [$this, 'replace'], ['is_safe' => ['all']]),
        ];
    }

    public function replace($subject, $pattern, $replacement, $limit = -1)
    {
        return preg_replace($pattern, $replacement, $subject, $limit);
    }
}
