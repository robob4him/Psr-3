<?php namespace Psr;

/**
 * PSR logger
 *
 * @uses AbstractLogger
 * @package Psr
 * @subpackage Example
 * @author Robert Koller <robob4him@gmail.com>
 * @license BSD
 */
class Logger extends Log\AbstractLogger {
    use Log\LoggerAwareTrait;

    /**
     * Array of conversion levels
     *
     * PSR 3 Log levels are string-based,
     * which is anti-PHP. Here
     * we can convert them to PHP levels
     * and still maintain compatibility.
     *
     * @var array
     * @access protected
     */
    protected $_aLevels = array(
                            'emergency' => 0,
                            'alert'     => 1,
                            'critical'  => 2,
                            'error'     => 3,
                            'warning'   => 4,
                            'notice'    => 5,
                            'info'      => 6,
                            'debug'     => 7,
                        );

    /**
     * Constants-to-string
     *
     * Representation of PHP levels
     *
     * @var array
     * @access protected
     */
    protected $_sLevels = array(
                            0 => 'EMERG',
                            1 => 'ALERT',
                            2 => 'CRIT',
                            3 => 'ERR',
                            4 => 'WARN',
                            5 => 'NOTICE',
                            6 => 'INFO',
                            7 => 'DEBUG',
                        );

    /**
     * Error string format
     *
     * @var string
     * @access protected
     */
    protected $_format = '%s: %s';

    /**
     * Log error
     *
     * @param mixed $level Error level (string or PHP syslog priority)
     * @param mixed $message Error message
     * @param array $context Contextual array
     *
     * @access public
     * @return void
     */
    public function log($level, $message, array $context = array()) {
        if (is_string($level)) {
            if (! array_key_exists($level, $this->_aLevels)) {
                $exMsg = "Log level {$level} is not valid. Please use syslog levels instead.";
                throw new Log\Exception\InvalidArgumentException($exMsg);
            } else {
                $level = $this->_aLevels[$level];
            }
        }
        if (array_key_exists('exception', $context)) {
            if($context['exception'] instanceof \Exception) {
                $exc = $context['exception'];
                $message .= " Exception: {$exc->getMessage()}";
                unset($context['exception']);
            } else {
                unset($context['exception']);
            }
        }

        if (null !== $this->logger) {
            $this->logger->log(sprintf($this->_format, $this->_sLevels[$level],
                                                       $this->interpolate($message, $context)));
        }
    }

    /**
     * Log an Exception
     *
     * @param mixed $level Error level (string or PHP syslog priority)
     * @param mixed $message Error message
     * @param array $context Contextual array
     * @param mixed $exception Exception
     *
     * @access public
     * @return void
     */
    public function logException($level, $message, array $context = array(), $exception = null) {
        $this->log($level, $message, array_merge($context, array('exception'=>$exception)));
    }

    /**
     * Interpolate string with parameters
     *
     * @param mixed $string String with parameters
     * @param array $params Parameter arrays
     *
     * @access protected
     * @return void
     */
    public function interpolate($string, array $params = array()) {
        foreach($params as $placeholder => $value) {
            $params['{' . (string) $placeholder . '}'] = (string) $value;
            unset($params[$placeholder]);
        }
        return strtr($string, $params);
    }
}
