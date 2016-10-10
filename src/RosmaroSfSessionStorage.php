<?php

namespace lukaszmakuch\RosmaroSf;

class RosmaroSfSessionStorage
{
    private $session;
    private $prefix;

    public function __construct($session, $prefix)
    {
        $this->session = $session;
        $this->prefix = $prefix;
    }

    public function getAllStatesDataFor(
        $rosmaroId,
        $stateDataToStoreIfNothingFound
    ) {
        if (!$this->session->has($this->getKeyFor($rosmaroId))) {
            $this->storeFor($rosmaroId, $stateDataToStoreIfNothingFound);
        }

        return $this->session->get($this->getKeyFor($rosmaroId));
    }

    public function getCurrentStateDataFor(
        $rosmaroId,
        $stateDataToStoreIfNothingFound
    ) {
        $allStatesData = $this->getAllStatesDataFor($rosmaroId, $stateDataToStoreIfNothingFound);
        return end($allStatesData);
    }

    public function removeAllDataFor($rosmaroId)
    {
        $this->session->remove($this->getKeyFor($rosmaroId));
    }

    public function storeFor($rosmaroId, $stateData)
    {
        $this->session->set(
            $this->getKeyFor($rosmaroId),
            array_merge(
                $this->session->get($this->getKeyFor($rosmaroId), []),
                [$stateData]
            )
        );
    }

    public function revertFor($rosmaroId, $stateId)
    {
        $newStack = [];
        foreach ($this->session->get($this->getKeyFor($rosmaroId), []) as $stateDataFromOldStack) {
            $newStack[] = $stateDataFromOldStack;
            if ($stateDataFromOldStack['id'] == $stateId) {
                break;
            }
        }

        $this->session->set($this->getKeyFor($rosmaroId), $newStack);
    }

    private function getKeyFor($rosmaroId)
    {
        return "$this->prefix:$rosmaroId";
    }
}
