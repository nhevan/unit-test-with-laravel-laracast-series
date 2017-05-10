<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\MailTracking;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MailSendingTest extends TestCase
{
	use MailTracking;

	/**
	 * @test
	 * a mail is sent
	 */
	public function a_mail_is_sent()
	{
		//act
	    $this->sendMail('from@bar.com', 'to@foo.com', 'body', 'subject');

	    //assert
	    $this->assertMailWasSent(1);
	}

	/**
	 * @test
	 * a mail was sent to given email address
	 */
	public function a_mail_was_sent_to_given_email_address()
	{
		//act
	    $this->sendMail('from@bar.com', 'to@foo.com', 'body', 'subject');
	
	    //assert
		$this->assertMailWasSent(1)
			 ->assertMailSentTo('to@foo.com')
			 ->assertMailNotSentTo('notSent@foo.com');
	}

	/**
	 * @test
	 * a mail was sent from a given email address
	 */
	public function a_mail_was_sent_from_a_given_email_address()
	{
	    //act
		$this->sendMail('from@bar.com', 'to@foo.com', 'body', 'subject');
	
	    //assert
	    $this->assertMailWasSent(1)
	    	 ->assertMailSentFrom('from@bar.com')
	    	 ->assertMailNotSentFrom('something@bar.com');
	}
}
