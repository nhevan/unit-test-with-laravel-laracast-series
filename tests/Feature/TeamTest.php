<?php

namespace Tests\Feature;

use App\Team;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamTest extends TestCase
{
	use DatabaseTransactions;
 	/**
     * @test
     * a team has a name
     */
    public function it_has_a_name()
    {
    	//arrange
    	$team = factory(Team::class)->create(['name' => 'Alpha']);
    
        //assert
		$this->assertEquals('Alpha', $team->name);        
    }

    /**
     * @test
     * a team can have multiple members
     */
    public function it_can_add_multiple_members()
    {
    	//arrange
        $team = factory(Team::class)->create();

        $memberOne = factory(User::class)->create();
        $memberTwo = factory(User::class)->create();
    
        //act
    	$team->addMember($memberOne);
    	$team->addMember($memberTwo);
    
        //assert
        $this->assertEquals(2, $team->count());
    }

    /**
     * @test
     * it can add multiple members at once
     */
    public function it_can_add_multiple_members_at_once()
    {
    	//arrange
        $team = factory(Team::class)->create();

        $members = factory(User::class, 3)->create();
    
        //act
        $team->addMember($members);
    	
        //assert
        $this->assertEquals(3, $team->count());
    }

    /**
     * @test
     * it has a maximum size
     */
    public function it_has_a_maximum_size()
    {
    	//arrange
        $team = factory(Team::class)->create(['size' => 2]);

        $memberOne = factory(User::class)->create();
        $memberTwo = factory(User::class)->create();
        $memberThree = factory(User::class)->create();
    
        //act
        $team->addMember($memberOne);
    	$team->addMember($memberTwo);

		//assert
        $this->setExpectedException('Exception');
    	$team->addMember($memberThree);
    }

    /**
     * @test
     * it can remove a member
     */
    public function it_can_remove_a_member()
    {
    	//arrange
        $team = factory(Team::class)->create();

        $memberOne = factory(User::class)->create();
        $memberTwo = factory(User::class)->create();
    	
    	$team->addMember($memberOne);
    	$team->addMember($memberTwo);

        //act
    	$team->removeMember($memberOne);
    
        //assert
        $this->assertEquals(1, $team->count());
    }

    /**
     * @test
     * it can remove all members at once
     */
    public function it_can_remove_all_members_at_once()
    {
    	//arrange
        $team = factory(Team::class)->create();

        $members = factory(User::class, 5)->create();
    	
    	$team->addMember($members);

        //act
    	$team->removeAllMembers();
    
        //assert
        $this->assertEquals(0, $team->count());
        
    }

    /**
     * @test
     * it can remove more than one users at once
     */
    public function it_can_remove_more_than_one_member_at_once()
    {
    	//arrange
        $team = factory(Team::class)->create();

        $members = factory(User::class, 5)->create();
    	
    	$team->addMember($members);
    
        //act
    	$team->removeMember($members->slice(0, 3));
    
        //assert
        $this->assertEquals(2, $team->count());
    }
}
