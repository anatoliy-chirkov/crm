<?php

class CallsController
{
    public function index()
    {
        Renderer::me()->setPath('calls/all.html')->render();
    }
}
