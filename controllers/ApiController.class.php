<?php

class ApiController
{
    const MANGO_API_URL = "https://app.mango-office.ru/vpbx/";

    public function index()
    {
        return true;
    }

    protected function eventCall()
    {
        if (!$_POST['events']['call'])
            return;
        

    }

    public function sign($data)
    {
        $json = json_encode($data);

        $sign =
            hash(
            "sha256",
            "ntwc8o86aekb8dja2phoc1d1hpj215nf".$json."o9hnngkokvpjyyjreq5gi88qohifdvkr"
            )
        ;

        return $sign;
    }

    public function curl($postdata)
    {
        $post = http_build_query($postdata);
        $ch = curl_init(self::MANGO_API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }



    /*
     *   Уникальный код вашей АТС
     *   ntwc8o86aekb8dja2phoc1d1hpj215nf
     *   Ключ для создания подписи
     *   o9hnngkokvpjyyjreq5gi88qohifdvkr
     */

    /*
        POST https://app.mango-office.ru/vpbx/commands/route
        vpbx_api_key = 5f4dcc3b5aa765d61d8327deb882cf99
        sign = 1imlsgivf5kprp16caur1468t5
        json = {
        "command_id" : "cmd.1.vpbx.12345.external.system.com.net",
        "call_id" : "100500",
        "to_number" : "74955404444"
        }
     */

    /*
     * Button "Back": $_SERVER['HTTP_REFERER'];
     */

}
