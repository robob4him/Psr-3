<?php

use Psr\Log;

class Logger extends AbstractLogger {
    use LoggerAwareTrait;

    protected $_aLevels = array(
                            'emergency' => LOG_EMERG,
                            'alert'     => LOG_ALERT,
                            'critical'  => LOG_CRIT,
                            'error'     => LOG_ERR,
                            'warning'   => LOG_WARNING,
                            'notice'    => LOG_NOTICE,
                            'info'      => LOG_INFO,
                            'debug'     => LOG_DEBUG,
                        );

    protected $_sLevels = array(
                            LOG_EMERG   => 'EMERG',
                            LOG_ALERT   => 'ALERT',
                            LOG_CRIT    => 'CRIT',
                            LOG_ERR     => 'ERR',
                            LOG_WARNING => 'WARN',
                            LOG_NOTICE  => 'NOTICE',
                            LOG_INFO    => 'INFO',
                            LOG_DEBUG   => 'DEBUG',
                        );

    protected $_format = '%s: %s';

    public function log($level, $message, array $context = array()) {
        if (is_string($level)) {
            if (! array_key_exists($level, $this->_aLevels)) {
                $exMsg = "Log level {$level} is not valid. Please use syslog levels instead.";
                throw new Exception\InvalidArgumentException($exMsg);
            } else {
                $level = $this->_aLevels[$level];
            }
        }
        if (array_key_exists('exception', $context)) {
            if($context['exception'] instanceof \Exception) {
                $exc = $context['exception'];
                $message .= "Exception: {$exc->getMessage()}";
                unset($context['exception']);
            } else {
                unset($context['exception']);
            }
        }

        if (null !== $this->logger) {
            $this->logger->log(sprintf($this->_format, $this->_sLevels[$level],
                                                       $message));
        }
    }

    public function logException($level, $message, array $context = array(), $exception = null) {
        $this->log($level, $message, array_merge($context, array('exception'=>$exception)));
    }

    protected function interpolate($string, array $params = array()) {
        foreach($params as $placeholder => $value) {
            $string = strtr($string, '{' . (string) $placeholder . '}', (string) $value);
        }
        return $string;
    }
}
