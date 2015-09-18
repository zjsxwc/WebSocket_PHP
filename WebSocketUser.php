<?php
/**
 * Created by IntelliJ IDEA.
 * User: wangchao
 * Date: 9/18/15
 * Time: 10:21 AM
 */

namespace WatcherHangzhou;


class WebSocketUser {

    public $socket;
    public $id;
    public $headers = array();
    public $handshake = false;

    public $handlingPartialPacket = false;
    public $partialBuffer = "";

    public $sendingContinuous = false;
    public $partialMessage = "";

    public $hasSentClose = false;

    public function __construct($id, $socket) {
        $this->id = $id;
        $this->socket = $socket;
    }
}