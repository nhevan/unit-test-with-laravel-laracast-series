<?php 

namespace Tests\Traits;

use Swift_Message;
use Swift_Events_EventListener;
use Illuminate\Support\Facades\Mail;

trait MailTracking{
	protected $emails = [];

	/** @before */
	public function setUpMailTracking()
	{
		Mail::getSwiftMailer()
			->registerPlugin(new MailTrackerPlugin($this));
	}

	/**
	 * checks to whom the email was sent to
	 * @param  [type] $to [description]
	 * @return [type]     [description]
	 */
	public function assertMailSentTo($to)
	{
		$last_email = end($this->emails);
		$this->assertArrayHasKey($to, $last_email->getTo());

		return $this;
	}

	/**
	 * checks to whom the email was NOT sent to
	 * @param  [type] $to [description]
	 * @return [type]     [description]
	 */
	public function assertMailNotSentTo($to)
	{
		$last_email = end($this->emails);
		$this->assertArrayNotHasKey($to, $last_email->getTo());

		return $this;
	}

	/**
	 * asserts from whom the email was sent
	 * @param  [type] $from [description]
	 * @return [type]       [description]
	 */
	public function assertMailSentFrom($from)
	{
		$last_email = end($this->emails);
		$this->assertArrayHasKey($from, $last_email->getFrom());

		return $this;
	}

	/**
	 * assert from whom the email was NOT sent to
	 * @param  [type] $from [description]
	 * @return [type]       [description]
	 */
	public function assertMailNotSentFrom($from)
	{
		$last_email = end($this->emails);
		$this->assertArrayNotHasKey($from, $last_email->getFrom());

		return $this;
	}

	/**
	 * checks the protected emails array and assert the count is okay or not
	 * @param  [type] $expected_count [description]
	 * @return [type]                 [description]
	 */
	public function assertMailWasSent($expected_count)
	{
		$sent_count = sizeof($this->emails);
		$this->assertCount($expected_count, $this->emails, "Expected ".$expected_count." emails to be sent, ".$sent_count." were sent.");

		return $this;
	}

	/**
	 * send a dummy mail
	 * @param  [type] $from    [description]
	 * @param  [type] $to      [description]
	 * @param  [type] $body    [description]
	 * @param  [type] $subject [description]
	 * @return [type]          [description]
	 */
	protected function sendMail($from, $to, $body, $subject)
	{
		Mail::raw($body, function ($message) use ($from, $to, $subject) {
	        $message->from($from, 'John Doe');
	    
	        $message->to($to, 'John Doe');
	    
	        $message->subject($subject);
	    });

	    return $this;
	}

	/**
	 * adds a swift message to the protected emails array
	 * @param Swift_Mime_Message $email [description]
	 */
	public function addEmail(Swift_Message $email)
	{
		$this->emails[] = $email;
	}
}


/**
* Dummy class to log mails for helping with test assertions
*/
class MailTrackerPlugin implements Swift_Events_EventListener
{
	protected $test;

	public function __construct($test)
	{
		$this->test = $test;
	}

	public function beforeSendPerformed($event)
    {
    	$this->test->addEmail($event->getMessage());
    }
}
