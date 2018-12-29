<?php

interface Betanet_Helpdesk_Model_ActionInterface
{
    /**
     * Get id
     *
     * @return string
     */
    public function getId();

    /**
     * Execute logic
     *
     * @param $eventArgs
     * @return void
     */
    public function execute($eventArgs);

    /**
     * Get input html
     *
     * @return string
     */
    public function getInputValueHtml();
}
