<?php

class CallsController
{
    public function index()
    {
        $data = new Calls;
        if (AuthChecker::me()->isMainRole()) {
            $data = $data->getCallsList();
        } else {
            $data = $data->getCallsListForMaster($_SESSION['id']);
        }

        Renderer::me()->setCalls($data)->setPath('calls/all.html')->render();
    }

    public function init()
    {
        $orderId = $_GET['order_id'];
        (new Calls)->init($_SESSION['id'], $_GET['phone']);

        header("Location: /orders/card?id=$orderId");
    }
}
