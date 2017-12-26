<?php

class CallsController
{
    public function index()
    {
        $data = new Calls;
        $data = $data->getCallsList();

        Renderer::me()->setCalls($data)->setPath('calls/all.html')->render();
    }
}
