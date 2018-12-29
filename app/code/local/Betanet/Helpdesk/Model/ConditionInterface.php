<?php

interface Betanet_Helpdesk_Model_ConditionInterface
{
    /**
     * Get id
     *
     * @return string
     */
    public function getId();

    /**
     * Validate event parameter
     *
     * @param $eventArgs
     * @return bool
     */
    public function isValid($eventArgs);

    /**
     * Get input html
     *
     * @return string
     */
    public function getInputValueHtml();
}
