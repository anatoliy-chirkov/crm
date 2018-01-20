<?php

class AutoVatsRequestBuilder
{
    /**
     * @param $data
     * @return mixed $response
     */
    public function buildAndSend($data)
    {
        $jsonData = json_encode($data);

        $hangupRequest = array(
            'vpbx_api_key' => VatsApi::VPBX_API_KEY,
            'sign' => $this->getSign($jsonData),
            'json' => $jsonData
        );

        $requestLink = VatsApi::VPBX_API_URL . $data['command_id'];

        $post = http_build_query($hangupRequest);
        $ch = curl_init($requestLink);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        curl_close($ch);

        $logResponse = $response . 'call_id: ' . $jsonData;
        $sql = "insert into log (body) values ('$logResponse')";
        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        return $response;
    }

    /**
     * @param $jsonData
     * @return string
     */
    private function getSign($jsonData)
    {
        $sign =
            hash(
                "sha256",
                "ntwc8o86aekb8dja2phoc1d1hpj215nf".$jsonData."o9hnngkokvpjyyjreq5gi88qohifdvkr"
            )
        ;

        return $sign;
    }
}
