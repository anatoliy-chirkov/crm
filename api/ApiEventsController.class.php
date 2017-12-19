<?php

class ApiEventsController
{
    public function call()
    {
        $data = $this->parsePostJsonRequest();

        $sql = "select id from spreaders where phone = '$data->from->number'";
        $dataSpreader = DB::me()->getConnection()->prepare($sql);
        $isSpreader = $dataSpreader->execute();

        if ($isSpreader) {
            //отбиваем звонок

            $spreaderId = $dataSpreader->fetch(PDO::FETCH_ASSOC);
            $spreaderId = $spreaderId['id'];

            $sql = "select id, count from spreaders_calls where spreader_id = $spreaderId and count < 4";
            $callData = DB::me()->getConnection()->prepare($sql);
            $isCallInOpenStatus = $callData->execute();

            if ($isCallInOpenStatus) {
                //update this call by id; first_call - second_call; *two iteration in one call
                $callData = $callData->fetch(PDO::FETCH_ASSOC);
                $id = $callData['id'];

                if ($callData['count'] < 3) {
                    $sql = "update spreaders_calls set count+1 where id = '$id'";
                    $res = DB::me()->getConnection()->prepare($sql);
                    $res->execute();
                } else {
                    $sql = "update spreaders_calls set count+1, second_call_time='$data->timestamp' where id = '$id'";
                    $res = DB::me()->getConnection()->prepare($sql);
                    $res->execute();
                }

            } else {
                //create call; set first_call_time;
                $sql = "insert into spreaders_calls (spreader_id, first_call_time, count) values ('$spreaderId', '$data->timestamp', 1)";

                $res = DB::me()->getConnection()->prepare($sql);
                $res->execute();
            }

            return;
        }

        $sql = "select master_id from orders where phone = '$data->from->number'";
        $infoAboutClient = DB::me()->getConnection()->prepare($sql);
        $isClientWithMaster = $infoAboutClient->execute();

        if ($isClientWithMaster) {
            $masterId = $infoAboutClient->fetch(PDO::FETCH_ASSOC);
            $masterId = $masterId['id'];

            $sql = "select phone from users where id = '$masterId'";
            $toPhone = DB::me()->getConnection()->prepare($sql)->fetch();
            $toPhone = $toPhone['phone'];

            $response = '';

            print_r($response);

        } else {
            //call to main phone
        }

        return;

        /*$api = new ApiController;

        $data = array();

        $sign = $api->sign($data);
        $json = json_encode($data);

        $api_key = 'ntwc8o86aekb8dja2phoc1d1hpj215nf';

        $postdata = array(
            'vpbx_api_key' => $api_key,
            'sign' => $sign,
            'json' => $json
        );

        $response = $postdata;
        print_r($response); */
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
        $data = strstr($_POST,'{');

        return json_decode($data);
    }
}
