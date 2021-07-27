<?php

use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;

require __DIR__ . '/../vendor/autoload.php';

$mailer = new SmtpMailer([
'host' => 'HOST',
'username' => 'USER',
'password' => 'PASSWORD',
//	'host' => 'smtp.seznam.cz',
//	'port' => 465,
//	'secure' => 'tls'
]);

$message = new Message();
$message->setFrom('FROM');
$message->setSubject('SUBJECT');
$message->addTo('TO');
$message->setBody('TEST');

$mailer->send($message);
