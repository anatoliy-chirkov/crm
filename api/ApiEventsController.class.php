<?php

class ApiEventsController
{
    public function call()
    {
        $data = $this->parsePostJsonRequest();

        $number = strval($data->from->number);


            $sql = "select id from spreaders where phone = '$number'";
            $resultSpreader = DB::me()->getConnection()->prepare($sql);
            $resultSpreader->execute();
            $dataSpreader = $resultSpreader->fetch(PDO::FETCH_ASSOC);

            $spreaderId = $dataSpreader['id'];

            $spreaderId
                ? $isSpreader = true
                : $isSpreader = false;

            if ($isSpreader) {

                $sql = "select id, count from spreaders_calls where spreader_id = '$spreaderId' and count < 4";
                $callData = DB::me()->getConnection()->prepare($sql);
                $callData->execute();
                $callData = $callData->fetch(PDO::FETCH_ASSOC);

                $id = $callData['id'];

                $id
                    ? $isCallInOpenStatus = true
                    : $isCallInOpenStatus = false;

                if ($isCallInOpenStatus) {

                    if ($callData['count'] < 3) {
                        $sql = "update spreaders_calls set count = count+1 where id = '$id'";
                        $res = DB::me()->getConnection()->prepare($sql);
                        $res->execute();
                    } else {
                        $sql = "update spreaders_calls set count = count+1, second_call_time='$data->timestamp' where id = '$id'";
                        $res = DB::me()->getConnection()->prepare($sql);
                        $res->execute();
                    }

                } else {

                    $sql = "insert into spreaders_calls (spreader_id, first_call_time, count) values ('$spreaderId', '$data->timestamp', 1)";

                    $res = DB::me()->getConnection()->prepare($sql);
                    $res->execute();
                }
            }

        if (strval($data->to->number) == '74994509495') {

            $sql = "select id from calls where call_id = '$data->call_id'";
            $callData = DB::me()->getConnection()->prepare($sql);
            $callData->execute();
            $callData = $callData->fetch(PDO::FETCH_ASSOC);

            $sql = "select id from orders where phone = '$number' or home_phone = '$number'";
            $orderData = DB::me()->getConnection()->prepare($sql);
            $orderData->execute();
            $orderData = $orderData->fetch(PDO::FETCH_ASSOC);
            $orderId = $orderData['id'];

            $id = $callData['id'];

            if ($id) {
                $sql = "update calls set end_time = '$data->timestamp' where id = '$id'";
                $res = DB::me()->getConnection()->prepare($sql);
                $res->execute();

                $sql = "update orders set status_id = 4 where id = $orderId";
                $res = DB::me()->getConnection()->prepare($sql);
                $res->execute();
            } else {
                $sql = "insert into calls (number, init_time, call_id, order_id) values ('$number', '$data->timestamp', '$data->call_id', '$orderId')";
                $res = DB::me()->getConnection()->prepare($sql);
                $res->execute();
            }
        }
    }

    public function summary()
    {
        return true;
    }

    public function get()
    {
        //string = vpboxapi_key + sha256(vpbx_api_key + json + vpbx_api_salt) + json
        $json = 'ntwc8o86aekb8dja2phoc1d1hpj215nf84728bcec48b2431d7569a86d2e7520184e931ea3a7bcb9852f71f0808bb3115{"entry_id":"MzQ1Mzc1MzUxMzoxNjE=","call_id":"MToxMDA3MTYxNToxNjE6Nzc2MTY1NjA4OjE=","timestamp":1513707786,"seq":1,"call_state":"Appeared","location":"ivr","from":{"number":"79997356761"},"to":{"number":"74994509495","line_number":"74994509495"}}';

        //$apiKey = 'ntwc8o86aekb8dja2phoc1d1hpj215nf';

        $data = strstr($json, '{');
        $data = json_decode($data);

        echo $data->from->number . $data->call_id . $data->timestamp;

        $data = strstr($_POST,'{');

    }

    private function parsePostJsonRequest()
    {
        $str = implode($_POST);
        $data = strstr($str,'{');

        return json_decode($data);
    }
}
