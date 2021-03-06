<?php

namespace App\DataTables;


trait DataTableTrait
{
    /**
     * Create badge
     *
     * @param String $text
     * @param String $type
     * @param Integer $margin
     * @return String
     */
    public function badge($text, $type, $margin = 0)
    {
        return '<span class="badge badge-' . $type . ' ml-' . $margin . '">' . __($text) . '</span>';
    }

    /**
     * Create button
     *
     * @param String $route
     * @param String $param
     * @param String $type
     * @param String $text
     * @return String
     */
    public function button($route, $param, $type, $title, $icon, $name = '', $target = '_self')
    {
        return '<a 
                    title="'. $title . '" 
                    data-name="' . $name . '" 
                    href="' . route($route, $param) . '" 
                    class="px-3 btn btn-xs mx-1 btn-' . $type . '" 
                    target="' . $target . '">
                    <i class="far fa-' . $icon . '"></i>
                </a>';
    }
}
