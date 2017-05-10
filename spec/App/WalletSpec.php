<?php

namespace spec\App;

use App\Wallet;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WalletSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Wallet::class);
    }

    function it_calls_get_balance_method()
    {
    	$this->balance()->shouldReturn("1000");
    }
}
