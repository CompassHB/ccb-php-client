<?php namespace CompassHB\Ccb;

use CompassHB\Ccb\Ccb;

class Calendar
{

  /**
   * @param DateTime $date_start
   * @param DateTime $date_end
   *
   * @return array of public calendar list items
   */
    public function publicCalendarListing($date_start = "2010-01-01", $date_end = null)
    {

        $args["date_start"] = Ccb::format_date($date_start);

        if (!empty($date_end)) {
            $args["date_end"] = Ccb::format_date($date_end);
        }

        $calendar_listing = Ccb::$api->get("public_calendar_listing", $args);
        return $calendar_listing->responseXML()->response->items->item;
    }


  /**
   * @param DateTime $date_start
   * @param DateTime $date_end
   *
   * @return array of public calendar list items
   */
    public function individualCalendarListing($individual_id, $date_start = "2010-01-01", $date_end = null)
    {

        $args["id"] = $individual_id;
        $args["date_start"] = Ccb::format_date($date_start);

        if (!empty($date_end)) {
            $args["date_end"] = Ccb::format_date($date_end);
        }

        $calendar_listing = Ccb::$api->get("public_calendar_listing", $args);
        return $calendar_listing->responseXML()->response->items->item;
    }
}
