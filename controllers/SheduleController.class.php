<?php

class SheduleController
{
    public function index()
    {
        Renderer::me()->setPath('shedule/index.html')->render();
        //include('lib/calendar/examples/metallic.html');
    }
}
