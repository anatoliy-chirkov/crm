<?php

class VatsRequestBuilder extends AutoVatsRequestBuilder
{
    /**
     * @return VatsRequestBuilder
     */
    public static function init()
    {
        return new self;
    }

    /**
     * @param $callId
     * @return mixed
     */
    public function hungUp($callId)
    {
        $data = array(
            'command_id' => 'commands/call/hangup',
            'call_id' => $callId
        );

        return $this->buildAndSend($data);
    }

    /**
     * @param string $fromPhone
     * @param string $toPhone
     * @return mixed
     */
    public function initCall($fromPhone, $toPhone)
    {
        $data = array(
            'command_id' => 'commands/callback',
            'from' => array(
                'extension' => 10,
                'number' => $fromPhone
            ),
            'to_number' => $toPhone,
            'line_number' => VatsApi::PHONE_FOR_CLIENTS
        );

        return $this->buildAndSend($data);
    }

    /**
     * @param string $fromPhone
     * @param string $toPhone
     * @return mixed
     */
    public function initGroupCall($fromPhone, $toPhone)
    {
        $data = array(
            'command_id' => 'commands/callback_group',
            'from' => $fromPhone,
            'to' => $toPhone,
            'line_number' => VatsApi::PHONE_FOR_CLIENTS
        );

        return $this->buildAndSend($data);
    }

    /**
     * @param $callId
     * @param $phone
     * @return mixed
     */
    public function startRecording($callId, $phone)
    {
        $data = array(
            'command_id' => 'commands/recording/start',
            'call_id' => $callId,
            'call_party_number' => $phone
        );

        return $this->buildAndSend($data);
    }

    /**
     * @param $recordingId
     * @return string
     */
    public function getRecordingLink($recordingId)
    {
        $time = time() + 300;
        $sign =
            hash(
                "sha256",
                "ntwc8o86aekb8dja2phoc1d1hpj215nf".$time.$recordingId."o9hnngkokvpjyyjreq5gi88qohifdvkr"
            )
        ;

        return
            VatsApi::VPBX_API_URL.'queries/recording/link/'.$recordingId.'/play/'.VatsApi::VPBX_API_KEY.'/'.$time.'/'.$sign;
    }

    public function getRecord()
    {
        $recordingId = $_POST['recording_id'];

        $data = array(
            'recording_id' => $recordingId,
            'action' => 'play'
        );

        // не закончен
    }

    /**
     * @param $callId
     * @param $toPhone
     * @return mixed
     */
    public function routeCall($callId, $toPhone)
    {
        $data = array(
            'command_id' => 'commands/route',
            'call_id' => $callId,
            'to_number' => $toPhone
        );

        $this->buildAndSend($data);
        $this->startRecording($callId, VatsApi::REAL_PHONE_MAIN);

        return;
    }
}
