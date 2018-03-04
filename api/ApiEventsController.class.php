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
        } else {
            VatsHandler::init()->handleOutgoingCall($call);
        }
    }

    public function summary()
    {
        return true;
    }

    public function recording()
    {
        $record = VatsRequestParser::init()->getRecordingData();

        $sql = "insert into record_log (entry_id, call_id, recording_id) values ('$record->entryId', '$record->callId', '$record->recordingId')";
        $callData = DB::me()->getConnection()->prepare($sql);
        $callData->execute();

        $sql = "update calls set recording_id = '$record->recordingId' where call_id = '$record->entryId'";
        $callData = DB::me()->getConnection()->prepare($sql);
        $callData->execute();
    }
}
