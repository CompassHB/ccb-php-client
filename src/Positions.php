<?php namespace CompassHB\Ccb;

use CompassHB\Ccb\Ccb;

class Positions
{

    public function all_positions()
    {
        $positions = Ccb::$api->get('position_list');
        return $positions->responseXML()->response->positions;
    }

    public function group_positions($group_id)
    {
        $group_positions = Ccb::$api->get('group_positions', [
            'id' => intval($group_id),
        ]);

        return $group_positions->responseXML()->response->groups->group->positions;
    }
}
