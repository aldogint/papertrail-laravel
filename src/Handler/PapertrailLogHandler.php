<?php
/**
 * Created by PhpStorm.
 * User: aldogint
 * Date: 13/09/17
 * Time: 17:39
 */

namespace PapertrailLaravel\Handler;

use Monolog\Logger;
use Monolog\Handler\SyslogUdp\UdpSocket;

class PapertrailLogHandler extends \Monolog\Handler\SyslogUdpHandler {
    protected $hostname;
    protected $ident;

    /**
     * @param string  $host
     * @param int     $port
     * @param mixed   $facility
     * @param int     $level    The minimum logging level at which this handler will be triggered
     * @param Boolean $bubble   Whether the messages that are handled can bubble up the stack or not
     * @param string  $ident    Program name or tag for each log message.
     */
    public function __construct($host, $port = 514, $hostname = null, $facility = LOG_USER, $level = Logger::DEBUG, $bubble = true, $ident = 'php')
    {
        parent::__construct($host, $port, $facility, $level, $bubble);

        $this->hostname = ($hostname) ? $hostname : gethostname();
        $this->ident = $ident;
    }

    /**
     * Make common syslog header (see rfc5424)
     */
    protected function makeCommonSyslogHeader($severity)
    {
        $priority = $severity + $this->facility;

        if (!$pid = getmypid()) {
            $pid = '-';
        }

        return "<$priority>1 " .
            $this->getDateTime() . " " .
            $this->hostname . " " .
            $this->ident . " " .
            $pid . " - - ";
    }

    /**
     * @author aldoginting
     * @return false|string
     *
     * For older version of monolog
     */
    protected function getDateTime()
    {
        return date(\DateTime::RFC3339);
    }
}