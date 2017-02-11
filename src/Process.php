<?php namespace CompassHB\Ccb;

use CompassHB\Ccb\Ccb;

class Process
{

    /**
     * @param int $id
     * @param string $status (optional)
     *
     * @return list of individuals in a queue with optional filter for certain status
     */
    public function queueIndividuals($id, $status = 'not-started')
    {
        $queue_individuals = Ccb::$api->get('queue_individuals', [
            'id' => $id,
            'status' => $status
        ]);

        return $queue_individuals->responseXML()->response->individuals->individual;
    }
}
