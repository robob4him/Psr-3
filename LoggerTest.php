<?php

require('Log/Exception/InvalidArgumentException.php');
require('Log/LogLevel.php');
require('Log/LoggerAwareTrait.php');
require('Log/LoggerInterface.php');
require('Log/AbstractLogger.php');
require('Logger.php');

class LoggerTest extends PHPUnit_Framework_TestCase {
    public $log;

    public function setup() {
        $logger = new Psr\Logger();
        $mlogger = new MockLogger();
        $logger->logger = $mlogger;
        $this->log = $logger;
    }

    public function testEmergency() {
        $this->setup();
        $this->log->emergency('test message');
        $this->assertEquals('EMERG: test message', $this->log->logger->loggedMessage);
        $this->log->emergency('{context} message', array('context'=>'test'));
        $this->assertEquals('EMERG: test message', $this->log->logger->loggedMessage);
        $this->log->emergency('{context} message', array('context'=>'test',
                                                         'exception'=>new Exception('test')));
        $this->assertEquals('EMERG: test message Exception: test',
                            $this->log->logger->loggedMessage);
    }

    public function testAlert() {
        $this->setup();
        $this->log->alert('test message');
        $this->assertEquals('ALERT: test message', $this->log->logger->loggedMessage);
        $this->log->alert('{context} message', array('context'=>'test'));
        $this->assertEquals('ALERT: test message', $this->log->logger->loggedMessage);
        $this->log->alert('{context} message', array('context'=>'test',
                                                     'exception'=>new Exception('test')));
        $this->assertEquals('ALERT: test message Exception: test',
                            $this->log->logger->loggedMessage);
    }

    public function testCritical() {
        $this->setup();
        $this->log->critical('test message');
        $this->assertEquals('CRIT: test message', $this->log->logger->loggedMessage);
        $this->log->critical('{context} message', array('context'=>'test'));
        $this->assertEquals('CRIT: test message', $this->log->logger->loggedMessage);
        $this->log->critical('{context} message', array('context'=>'test',
                                                        'exception'=>new Exception('test')));
        $this->assertEquals('CRIT: test message Exception: test',
                            $this->log->logger->loggedMessage);
    }

    public function testError() {
        $this->setup();
        $this->log->error('test message');
        $this->assertEquals('ERR: test message', $this->log->logger->loggedMessage);
        $this->log->error('{context} message', array('context'=>'test'));
        $this->assertEquals('ERR: test message', $this->log->logger->loggedMessage);
        $this->log->error('{context} message', array('context'=>'test',
                                                     'exception'=>new Exception('test')));
        $this->assertEquals('ERR: test message Exception: test',
                            $this->log->logger->loggedMessage);
    }

    public function testWarning() {
        $this->setup();
        $this->log->warning('test message');
        $this->assertEquals('WARN: test message', $this->log->logger->loggedMessage);
        $this->log->warning('{context} message', array('context'=>'test'));
        $this->assertEquals('WARN: test message', $this->log->logger->loggedMessage);
        $this->log->warning('{context} message', array('context'=>'test',
                                                       'exception'=>new Exception('test')));
        $this->assertEquals('WARN: test message Exception: test',
                            $this->log->logger->loggedMessage);
    }

    public function testNotice() {
        $this->setup();
        $this->log->notice('test message');
        $this->assertEquals('NOTICE: test message', $this->log->logger->loggedMessage);
        $this->log->notice('{context} message', array('context'=>'test'));
        $this->assertEquals('NOTICE: test message', $this->log->logger->loggedMessage);
        $this->log->notice('{context} message', array('context'=>'test',
                                                      'exception'=>new Exception('test')));
        $this->assertEquals('NOTICE: test message Exception: test',
                            $this->log->logger->loggedMessage);
    }

    public function testInfo() {
        $this->setup();
        $this->log->info('test message');
        $this->assertEquals('INFO: test message', $this->log->logger->loggedMessage);
        $this->log->info('{context} message', array('context'=>'test'));
        $this->assertEquals('INFO: test message', $this->log->logger->loggedMessage);
        $this->log->info('{context} message', array('context'=>'test',
                                                    'exception'=>new Exception('test')));
        $this->assertEquals('INFO: test message Exception: test',
                            $this->log->logger->loggedMessage);
    }

    public function testDebug() {
        $this->setup();
        $this->log->debug('test message');
        $this->assertEquals('DEBUG: test message', $this->log->logger->loggedMessage);
        $this->log->debug('{context} message', array('context'=>'test'));
        $this->assertEquals('DEBUG: test message', $this->log->logger->loggedMessage);
        $this->log->debug('{context} message', array('context'=>'test',
                                                     'exception'=>new Exception('test')));
        $this->assertEquals('DEBUG: test message Exception: test',
                            $this->log->logger->loggedMessage);
    }

    public function testLog() {
        $this->log->log(Psr\Log\LogLevel::EMERGENCY, 'test message');
        $this->assertEquals('EMERG: test message', $this->log->logger->loggedMessage);
        $this->log->log(Psr\Log\LogLevel::ALERT, 'test message');
        $this->assertEquals('ALERT: test message', $this->log->logger->loggedMessage);
        $this->log->log(Psr\Log\LogLevel::CRITICAL, 'test message');
        $this->assertEquals('CRIT: test message', $this->log->logger->loggedMessage);
        $this->log->log(Psr\Log\LogLevel::ERROR, 'test message');
        $this->assertEquals('ERR: test message', $this->log->logger->loggedMessage);
        $this->log->log(Psr\Log\LogLevel::WARNING, 'test message');
        $this->assertEquals('WARN: test message', $this->log->logger->loggedMessage);
        $this->log->log(Psr\Log\LogLevel::NOTICE, 'test message');
        $this->assertEquals('NOTICE: test message', $this->log->logger->loggedMessage);
        $this->log->log(Psr\Log\LogLevel::INFO, 'test message');
        $this->assertEquals('INFO: test message', $this->log->logger->loggedMessage);
        $this->log->log(Psr\Log\LogLevel::DEBUG, 'test message');
        $this->assertEquals('DEBUG: test message', $this->log->logger->loggedMessage);

        // Windows syslog error levels
        if (LOG_EMERG === LOG_ALERT) {
            $aLevels = array(
                LOG_ALERT   => 'ALERT:',
                LOG_ERR     => 'WARN:',
                LOG_WARNING => 'NOTICE:',
                LOG_INFO    => 'INFO:',
            );
        } else {
            $aLevels = array(
                LOG_EMERG   => 'EMERG:',
                LOG_ALERT   => 'ALERT:',
                LOG_CRIT    => 'CRIT:',
                LOG_ERR     => 'ERR:',
                LOG_WARNING => 'WARN:',
                LOG_NOTICE  => 'NOTICE:',
                LOG_INFO    => 'INFO:',
                LOG_DEBUG   => 'DEBUG:',
            );
        }

        foreach ($aLevels as $level => $prepend) {
            $this->log->log($level, 'test message');
            $this->assertEquals("$prepend test message", $this->log->logger->loggedMessage);
        }
    }

    public function testInterpolate() {
        $this->setup();
        $this->assertEquals('test message', $this->log->interpolate('test message'));
        $this->assertEquals('test message', $this->log->interpolate('test message',
                                                                    array('test'=>'test')));
        $this->assertEquals('test message', $this->log->interpolate('{test} message',
                                                                    array('test'=>'test')));
        $this->assertEquals('test message', $this->log->interpolate('{test} {message}',
                                                                    array('test'=>'test',
                                                                    'message'=>'message')));
        $this->assertEquals('test message',
                            $this->log->interpolate('{test-message}',
                                                    array('test-message'=>'test message')));
    }

    public function testLogException() {
        $this->setup();
        $this->log->log(LOG_ERR, 'test message Exception: test');
        $message1 = $this->log->logger->loggedMessage;
        $this->log->logException(LOG_ERR, 'test message', array(), new Exception('test'));
        $message2 = $this->log->logger->loggedMessage;
        $this->assertEquals($message1, $message2);

        $this->log->log(LOG_ERR, 'test message');
        $message1 = $this->log->logger->loggedMessage;
        $this->log->logException(LOG_ERR, 'test message');
        $message2 = $this->log->logger->loggedMessage;
        $this->assertEquals($message1, $message2);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgument() {
        $this->setup();
        $this->log->log('invalid code', 'test message');
    }
}

class MockLogger {
    public $loggedMessage = '';
    public function log($message) {
        $this->loggedMessage = $message;
    }
}
