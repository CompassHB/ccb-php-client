<?php

namespace CompassHB\Ccb;

use CompassHB\Ccb\Ccb;
use CompassHB\Ccb\Enums\GroupStatus;

class Groups
{

	/**
	 * Adds an individual to a group
	 * @param int $id
	 * @param int $group_id
	 * @param string $status
	 *
	 * @return array
	 */
	public function addIndividualToGroup(int $id, int $group_id, string $status)
	{

		// Check if status is allowed. If not, die
		if(!GroupStatus::has(strtolower($status))) {
			return false;
		}

		$group = Ccb::$api->get(
			'add_individual_to_group', [
				'id'		=> $id,
				'group_id'	=> $group_id,
				'status'	=> strtolower($status),
			]
		);

		return $group->responseXML()->groups->group;

	}

	/**
	 * adds an individual to queue
	 * @param int $individual_id
	 * @param int $queue_id
	 * @param array $extraData (nullable, can contain manager_id and note)
	 * @return array
	 */
	public function addIndividualToQueue(int $individual_id, int $queue_id, array $extraData = [])
	{

		$data = array_merge(
			[
				'individual_id'	=> $individual_id,
				'queue_id'		=> $queue_id,
			],
			$extraData
		);

		$group = Ccb::$api->get('add_individual_to_queue', $data);

		return $group->responseXML()
					->individuals
					->individual;

	}

	/**
	 * creates a group
	 * @param  string $name
	 * @param  int    $campus_id
	 * @param  int    $main_leader_id
	 * @param  array  $extraData (nullable, can contain description,
	 * group_type_id, department_id, area_id, group_capacity,
	 * meeting_location_street_address, meeting_location_city,
	 * meeting_location_state, meeting_location_zip, meeting_day_id,
	 * meeting_time_id, childcare_provided, interaction_type,
	 * membership_type, listed, public_search_listed,
	 * udf_group_pulldown_1_id, udf_group_pulldown_2_id,
	 * udf_group_pulldown_3_id)
	 * @return array
	 */
	public function createGroup(string $name, int $campus_id, int $main_leader_id, array $extraData = [])
	{

		$data = array_merge(
			[
				'name'				=> $name,
				'campus_id'			=> $campus_id,
				'main_leader_id'	=> $main_leader_id,
			],
			$extraData
		);

		$group = Ccb::$api->get('create_group', $data);

		return $group->responseXML()
					->groups
					->group;
	}

	/**
	 * creates a new group position
	 * @param  string $name
	 * @param  int    $group_id
	 * @param  int    $owner_id
	 * @param  int    $type_id
	 * @param  bool   $inactive
	 * @param  bool   $non_scheduled
	 * @param  bool   $external_listed
	 * @param  bool   $listed
	 * @param  array  $extraData (nullable, can contain creator_id,
	 * qualifications, fills_currently_max_quantity, spiritual_maturity_id,
	 * description)
	 * @return array
	 */
	public function createGroupPosition(
		string $name,
		int $group_id,
		int $owner_id,
		int $type_id,
		bool $inactive,
		bool $non_scheduled,
		bool $external_listed,
		bool $listed,
		array $extraData = []
	)
	{

		$data = array_merge(
			[
				'name'				=> $name,
				'group_id'			=> $group_id,
				'owner_id'			=> $owner_id,
				'type_id'			=> $type_id,
				'inactive'			=> $inactive,
				'non_scheduled'		=> $non_scheduled,
				'external_listed'	=> $external_listed,
				'listed'			=> $listed,
			],
			$extraData
		);

		$group = Ccb::$api->get('create_group_position', $data);

		return $group->responseXML()
					->groups
					->group;

	}

	/**
	 * gets listed group needs
	 * @param  int    $id
	 * @return array
	 */
	public function groupNeeds(int $id)
	{

		$group = Ccb::$api->get(
			'group_needs', [
				'id'		=> $id,
			]
		);

		return $group->responseXML()->groups->group->needs;

	}

	/**
	 * gets group participants
	 * @param  int    $id
	 * @param  array  $extraData (nullable, can include include_inactive,
	 * modified_since (datetime in ISO-8601 format))
	 * @return array
	 */
	public function groupParticipants(int $id, array $extraData)
	{

		$data = array_merge(
			[
				'id'	=> $id,
			],
			$extraData
		);

		$group = Ccb::$api->get('group_participants', $data);

		return $group->responseXML()
					->groups
					->group
					->participants;

	}

	/**
	 * manages leaders of a chosen group
	 * @param  int    $group_id
	 * @param  array  $leader_ids
	 * @return array
	 */
	public function manageGroupLeaders(int $group_id, array $leader_ids)
	{

		$data = [
			'group_id'		=> $group_id,
			'leader_ids'	=> $leader_ids,
		];

		$group = Ccb::$api->get('group_participants', $data);

		return $group->responseXML()
					->group
					->leaders;

	}

	/**
	 * gets listed group positions
	 * @param  int    $id
	 * @return array
	 */
	public function groupPositions(int $id)
	{

		$group = Ccb::$api->get(
			'group_positions', [
				'id'		=> $id,
			]
		);

		return $group->responseXML()->groups->group->positions;

	}

	/**
	 * gets group profile
	 * @param  int          $id
	 * @param  bool|boolean $include_image_link (defaults to false)
	 * @return array
	 */
	public function groupProfileFromID(int $id, bool $include_image_link = false)
	{

		$data = [
			'id'					=> $id,
			'include_image_link'	=> $include_image_link,
		];

		$group = Ccb::$api->get('group_profile_from_id', $data);

		return $group->responseXML()->groups->group;

	}

	/**
	 * gets all groups
	 * @param  array  $extraData (nullable, can include modified_since,
	 * include_participants, include_image_link, page, per_page)
	 * @return array
	 */
	public function groupProfiles(array $extraData = [])
	{

		$groups = Ccb::$api->get('group_profiles', $extraData);

		return $groups->responseXML()->groups;

	}

	/**
	 * gets all positions across groups
	 * @return array
	 */
	public function positionList()
	{

		$group = Ccb::$api->get('position_list');

		return $group->responseXML()->positions;

	}

	/**
	 * removes an individual from group
	 * @param  int    $id
	 * @param  int    $group_id
	 * @return array
	 */
	public function removeIndividualFromGroup(int $id, int $group_id)
	{

		$data = [
			'id'		=> $id,
			'group_id'	=> $group_id,
		];

		$group = Ccb::$api->get('remove_individual_from_group');

		return $group->responseXML()->groups->group;

	}

	/**
	 * updates group. Highly recommended to check the docs for this one.
	 * @param  int    $id
	 * @param  array  $extraData (nullable, check documentation for params)
	 * @return array
	 */
	public function updateGroup(int $id, array $extraData)
	{

		$data = array_merge(
			[
				'id'	=> $id
			],
			$extraData
		);

		$group = Ccb::$api->post('update_group');

		return $group->responseXML()->groups->group;

	}

	/**
	 * updates group position
	 * @param  int    $id
	 * @param  array  $extraData (nullable, can include name, description,
	 * qualifications, group_id, type_id, fills_currently_max_quantity,
	 * spiritual_maturity_id, inactive, non_scheduled, listed, abilities,
	 * gifts, passions, styles)
	 * @return array
	 */
	public function updateGroupPosition(int $id, array $extraData)
	{

		$data = array_merge(
			[
				'id'	=> $id
			],
			$extraData
		);

		$group = Ccb::$api->post('update_group_position');

		return $group->responseXML()->positions->position;

	}

}