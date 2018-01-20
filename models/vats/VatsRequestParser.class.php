<?php

class VatsRequestParser
{
    public static function init()
    {
        return new self;
    }

    public function getCallData()
    {
        $data = $this->parseArray();

        $requestData = new VatsRequestData();

        $requestData->toPhone = strval($data->to->number);
        $requestData->fromPhone = strval($data->from->number);
        $requestData->callId = strval($data->call_id);
        $requestData->callState = strval($data->call_state);
        $requestData->time = $data->timestamp;

        return $requestData;
    }

    public function getRecordingData()
    {
        $data = $this->parseArray();

        $requestData = new VatsRequestData();

        $requestData->recordingId = strval($data->recording_id);
        $requestData->recordingState = strval($data->recording_state);
        $requestData->callId = strval($data->call_id);

        return $requestData;
    }

    private function parseArray()
    {
        $str = implode($_POST);
        $data = strstr($str,'{');

        return json_decode($data);
    }
}
