<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	protected $members;
	protected $fillable = ['name', 'size'];

	/**
	 * adds a user to the team
	 * @param [type] $user [description]
	 */
	public function addMember($user)
	{
        $this->guardAgainstTooManyMembers();

		$method = $user instanceof User ? 'save' : 'saveMany';
		$this->members()->$method($user);
	}

	/**
	 * removes a user from the team
	 * @param  User   $user [description]
	 * @return [type]       [description]
	 */
	public function removeMember($users)
	{
		if ($users instanceof User) {
			$users->team_id = null;
			return $users->save();
		}

		$this->removeMany($users);
	}

	/**
	 * removes multiple members from a team
	 * @param  [type] $users [description]
	 * @return [type]        [description]
	 */
	public function removeMany($users)
	{
		foreach ($users as $user) {
			$this->removeMember($user);
		}
	}

	/**
	 * removes all users from the team
	 * @return [type] [description]
	 */
	public function removeAllMembers()
	{
		foreach ($this->members()->get() as $member) {
			$this->removeMember($member);
		}
	}

	/**
	 * guards against assignment of too many members
	 * @return [type] [description]
	 */
    private function guardAgainstTooManyMembers()
    {
  		if ($this->members()->count() == $this->size) {
  			throw new \Exception;
  		}
    }

    /**
     * defines has many relationship with User
     * @return [type] [description]
     */
	public function members()
	{
		return $this->hasMany('App\User');
	}

	/**
	 * returns the count of members in a team
	 * @return [type] [description]
	 */
	public function count()
	{
		return $this->members()->count();
	}
}
