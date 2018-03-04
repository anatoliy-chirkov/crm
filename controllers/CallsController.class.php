<?php

class CallsController
{
    public function index()
    {
        $data = new Calls;
        if (AuthChecker::me()->isMainRole()) {
            $calls = $data->getCallsList();
            $callsOutgoing = $data->getCallsList($outgoing = 1);
        } else {
            $calls = $data->getCallsListForMaster($_SESSION['id']);
            $callsOutgoing = $data->getCallsListForMaster($_SESSION['id'], $outgoing = 1);
        }

        Renderer::me()->setCalls($calls)->setCallsOutgoing($callsOutgoing)->setPath('calls/all.html')->render();
    }

    public function init()
    {
        $orderId = $_GET['order_id'];
        (new Calls)->init($_SESSION['id'], $_GET['phone']);

        header("Location: /orders/card?id=$orderId");
    }
}
