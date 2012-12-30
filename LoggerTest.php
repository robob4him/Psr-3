<?php

include('logger.php');

class LoggerTest extends Logger {
    public function setup() {
        $mlogger = new MockLogger();
        $this->logger = $mlogger;
    }

    public function testEmergency() {
        $this->setup();
        $this->emergency('test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->emergency('{context} message', array('context'=>'test'));
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->emergency('{context} message', array('context'=>'test',
                                                    'exception'=>new Exception('test')));
        $this->assertEquals('test message Exception: test', $this->logger->loggedMessage);
        $this->log(LOG_EMERG, 'test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
    }

    public function testAlert() {
        $this->setup();
        $this->alert('test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->alert('{context} message', array('context'=>'test'));
        $this->assertEquals('test message', $log->logger->loggedMessage);
        $this->alert('{context} message', array('context'=>'test',
                                                'exception'=>new Exception('test')));
        $this->assertEquals('test message Exception: test', $this->logger->loggedMessage);
        $this->log(LOG_ALERT, 'test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
    }


    public function testCritical() {
        $this->setup();
        $this->critical('test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->critical('{context} message', array('context'=>'test'));
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->critical('{context} message', array('context'=>'test',
                                                   'exception'=>new Exception('test')));
        $this->assertEquals('test message Exception: test', $this->logger->loggedMessage);
        $this->log(LOG_CRIT, 'test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
    }

    public function testError() {
        $this->setup();
        $this->error('test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->error('{context} message', array('context'=>'test'));
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->error('{context} message', array('context'=>'test',
                                                'exception'=>new Exception('test')));
        $this->assertEquals('test message Exception: test', $this->logger->loggedMessage);
        $this->log(LOG_ERR, 'test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
    }

    public function testWarning() {
        $this->setup();
        $this->warning('test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->warning('{context} message', array('context'=>'test'));
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->warning('{context} message', array('context'=>'test',
                                                  'exception'=>new Exception('test')));
        $this->assertEquals('test message Exception: test', $this->logger->loggedMessage);
        $this->log(LOG_WARNING, 'test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
    }

    public function testNotice() {
        $this->setup();
        $this->notice('test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->notice('{context} message', array('context'=>'test'));
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->notice('{context} message', array('context'=>'test',
                                                 'exception'=>new Exception('test')));
        $this->assertEquals('test message Exception: test', $this->logger->loggedMessage);
        $this->log(LOG_NOTICE, 'test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
    }

    public function testInfo() {
        $this->setup();
        $this->info('test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->info('{context} message', array('context'=>'test'));
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->info('{context} message', array('context'=>'test',
                                               'exception'=>new Exception('test')));
        $this->assertEquals('test message Exception: test', $this->logger->loggedMessage);
        $this->log(LOG_INFO, 'test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
    }

    public function testDebug() {
        $this->setup();
        $this->debug('test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->debug('{context} message', array('context'=>'test'));
        $this->assertEquals('test message', $this->logger->loggedMessage);
        $this->debug('{context} message', array('context'=>'test',
                                                'exception'=>new Exception('test')));
        $this->assertEquals('test message Exception: test', $this->logger->loggedMessage);
        $this->log(LOG_DEBUG, 'test message');
        $this->assertEquals('test message', $this->logger->loggedMessage);
    }

    public function testInterpolate() {
        $this->setup();
        $this->assertEquals('test message', $this->interpolate('test message'));
        $this->assertEquals('test message', $this->interpolate('test message',
                                                               array('test'=>'test')));
        $this->assertEquals('test message', $this->interpolate('{test} message',
                                                               array('test'=>'test')));
        $this->assertEquals('test message', $this->interpolate('{test} {message}',
                                                               array('test'=>'test',
                                                                     'message'=>'message')));
        $this->assertEquals('test message', $this->interpolate('{test-message}',
                                                           array('test-message'=>'test message')));
    }

    public function testLogException() {
        $this->setup();
        $this->log(LOG_ERR, 'test message Exception: test');
        $message1 = $this->logger->loggedMessage;
        $this->logException(LOG_ERR, 'test message', array(), new Exception('test'));
        $message2 = $this->logger->loggedMessage;
        $this->assertEquals($message1, $message2);
    }
}

class MockLogger {
    public $loggedMessage = '';
    public function log($message) {
        $this->loggedMessage = $message;
    }
}
