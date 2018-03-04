<?php

class VatsHandler
{
    public static function init()
    {
        return new self;
    }

    public function handleOutgoingCall($call)
    {
        /** В течении 1 звонка поступает несолько уведомлений */
        $sql = "select id from calls where call_id = '$call->callId'";
        $callData = DB::me()->getConnection()->prepare($sql);
        $callData->execute();
        $callData = $callData->fetch(PDO::FETCH_ASSOC);

        $sql = "select * from orders where phone = '$call->toPhone' or home_phone = '$call->toPhone'";
        $orderData = DB::me()->getConnection()->prepare($sql);
        $orderData->execute();
        $orderData = $orderData->fetch(PDO::FETCH_ASSOC);
        $orderId = $orderData['id'];

        /** Если это не первый запрос по заданному звонку - обновляем данные по этому 1 звонку */
        $id = $callData['id'];

        if (isset($id)) {

            if ($call->callState == 'Connected') {
                $sql = "update calls set connected_time = '$call->time' where id = '$id'";
                $res = DB::me()->getConnection()->prepare($sql);
                $res->execute();
            } elseif ($call->callState == 'Disconnected') {
                $sql = "update calls set end_time = '$call->time', number = '$call->toPhone', order_id = '$orderId' where id = '$id'";
                $res = DB::me()->getConnection()->prepare($sql);
                $res->execute();
            }

            $sql = "update orders set status_id = 4 where id = $orderId";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
        } else {
            $sql = "insert into calls (number, init_time, call_id, order_id, outgoing) values ('$call->toPhone', '$call->time', '$call->callId', '$orderId', 1)";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();

            //VatsRequestBuilder::init()->startRecording($call->callIdReal, VatsApi::PHONE_FOR_CLIENTS);
            VatsRequestBuilder::init()->startRecording($call->callIdReal, $call->toPhone);
        }
    }

    public function handleClientCall($call)
    {
        /** В течении 1 звонка поступает несолько уведомлений */
        $sql = "select id from calls where call_id = '$call->callId'";
        $callData = DB::me()->getConnection()->prepare($sql);
        $callData->execute();
        $callData = $callData->fetch(PDO::FETCH_ASSOC);

        $sql = "select * from orders where phone = '$call->fromPhone' or home_phone = '$call->fromPhone'";
        $orderData = DB::me()->getConnection()->prepare($sql);
        $orderData->execute();
        $orderData = $orderData->fetch(PDO::FETCH_ASSOC);
        $orderId = $orderData['id'];
        $masterId = $orderData['master_id'];

        $sql = "select * from users where id = '$masterId'";
        $orderData = DB::me()->getConnection()->prepare($sql);
        $orderData->execute();
        $orderData = $orderData->fetch(PDO::FETCH_ASSOC);
        $masterPhone = $orderData['phone'];

        /** Если это не первый запрос по заданному звонку - обновляем данные по этому 1 звонку */
        $id = $callData['id'];

        if (isset($id)) {

            if ($call->callState == 'Connected') {
                $sql = "update calls set connected_time = '$call->time' where id = '$id'";
                $res = DB::me()->getConnection()->prepare($sql);
                $res->execute();
            } elseif ($call->callState == 'Disconnected') {
                $sql = "update calls set end_time = '$call->time', number = '$call->fromPhone', order_id = '$orderId' where id = '$id'";
                $res = DB::me()->getConnection()->prepare($sql);
                $res->execute();
            }

            $sql = "update orders set status_id = 4 where id = $orderId";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
        } else {
            $sql = "insert into calls (number, init_time, call_id, order_id) values ('$call->fromPhone', '$call->time', '$call->callId', '$orderId')";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
        }

        $stopRouting = $orderData['stop_routing'];

        if ($stopRouting == 0 || $stopRouting == null) {
            VatsRequestBuilder::init()->routeCall($call->callIdReal, $masterPhone);
        }

        VatsRequestBuilder::init()->startRecording($call->callIdReal, VatsApi::REAL_PHONE_MAIN);
    }

    public function handleSpreaderCall($call)
    {
        $spreaderId = $this->getSpreaderIdByCall($call);

        if (isset($spreaderId)) {
            $sql = "select id, count from spreaders_calls where spreader_id = '$spreaderId' and count < 4";
            $callData = DB::me()->getConnection()->prepare($sql);
            $callData->execute();
            $callData = $callData->fetch(PDO::FETCH_ASSOC);
            $id = $callData['id'];

            if (isset($id)) {

                if ($callData['count'] < 3) {
                    $sql = "update spreaders_calls set count = count+1 where id = '$id'";
                    $res = DB::me()->getConnection()->prepare($sql);
                    $res->execute();
                } else {
                    $sql = "update spreaders_calls set count = count+1, second_call_time='$call->time' where id = '$id'";
                    $res = DB::me()->getConnection()->prepare($sql);
                    $res->execute();
                }

            } else {
                $sql = "insert into spreaders_calls (spreader_id, first_call_time, count) values ('$spreaderId', '$call->time', 1)";
                $res = DB::me()->getConnection()->prepare($sql);
                $res->execute();
            }

            VatsRequestBuilder::init()->hungUp($call->callId);
        }
    }

    private function getSpreaderIdByCall($call)
    {
        $sql = "select id from spreaders where phone = '$call->fromPhone' and dismissed is null";
        $resultSpreader = DB::me()->getConnection()->prepare($sql);
        $resultSpreader->execute();
        $dataSpreader = $resultSpreader->fetch(PDO::FETCH_ASSOC);

        return $dataSpreader['id'];
    }
}
