<?php

class ApiEventsController
{
    public function call()
    {
        $call = VatsRequestParser::init()->getCallData();

        if ($call->toPhone == VatsApi::PHONE_FOR_SPREADERS) {
            VatsHandler::init()->handleSpreaderCall($call);
        } elseif ($call->toPhone == VatsApi::PHONE_FOR_CLIENTS) {
            VatsHandler::init()->handleClientCall($call);
        }
    }

    public function summary()
    {
        return true;
    }

    public function recording()
    {
        $record = VatsRequestParser::init()->getRecordingData();

        $sql = "update calls set recording_id = '$record->recordingId' where call_id = '$record->callId'";
        $callData = DB::me()->getConnection()->prepare($sql);
        $callData->execute();
    }
}
