<?php namespace CompassHB\Ccb;

use CompassHB\Ccb\Ccb;

class Family
{

  /**
   * @param int $id
   *
   * @return array of public calendar list items
   */
    public function familyDetail($id)
    {

        $family_detail = Ccb::$api->get("family_detail", [
        "family_id" => intval($id)
        ]);
        return $family_detail->responseXML()->items->item;
    }


  /**
   * @param int $id
   *
   * @return array of public calendar list items
   */
    public function familyList($id = null)
    {

        $family_id = array();

        if (isset($id)) {
            $family_id["family_id"] = intval($id);
        }

        $family_list = Ccb::$api->get("family_list", $family_id);
        return $family_list->responseXML()->response->families->family;
    }
}
