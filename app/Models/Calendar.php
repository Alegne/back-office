<?php

namespace App\Models;

class Calendar
{
    /**
     * Attributes
     */
    public $id;
    public $title;
    public $start;
    public $end;
    public $backgroundColor;
    public $borderColor;
    public $enseignant;
    public $specification;

    public function __construct($id, $title, $start, $end, $color, $enseignant, $specification)
    {
        $this->id              = $id;
        $this->title           = $title;
        $this->start           = $start;
        $this->end             = $end;
        $this->backgroundColor = $color;
        $this->borderColor     = $color;
        $this->enseignant      = $enseignant;
        $this->specification   = $specification;
    }


}
