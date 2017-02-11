<?php namespace CompassHB\Ccb;

use CompassHB\Ccb\Ccb;

class Individual
{

  /**
   * @param int $id
   *
   * @return array of public calendar list items
   */
    public function individualProfileFromId($id)
    {

        $individual_profile = Ccb::$api->get("individual_profile_from_id", [
        "individual_id" => intval($id)
        ]);
        return $individual_profile->responseXML()->response->individuals->individual;
    }


    public function updateIndividual($id, $params = array())
    {
        $individual_params = array(
            "individual_id" => intval($id)
        );

        $updated_individual = Ccb::$api->post("update_individual", $individual_params, $params);
        return $updated_individual;
    }

    public function savedSearch($id)
    {
        $search_params = array(
        "id" => intval($id)
        );

        $search_results = Ccb::$api->get("execute_search", $search_params);
        return $search_results->responseXML()->response->individuals->individual;
    }
}
