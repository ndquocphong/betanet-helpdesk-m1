<?php

class Betanet_Helpdesk_Model_Condition_PicCondition extends Betanet_Helpdesk_Model_AbstractCondition
{
    /**
     * {@inheritdoc}
     *
     * @param $pic
     * @return bool
     */
    public function isValid($pic)
    {
        if (!$pic instanceof Betanet_Helpdesk_Model_Pic) {
            return false;
        }

        error_log(__METHOD__);

        return in_array($pic->getId(), explode(',', $this->getValue()));
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getInputValueHtml()
    {
        $source =  Mage::getSingleton('betanet_helpdesk/config_source_pic')->toOptionArray();
        $html = '<select class="select" style="width: 100%" name="[value][]" multiple>';
        foreach ($source as $item) {
            $html .= "<option value=\"{$item['value']}\">{$item['label']}</option>";
        }
        $html .= '</select>';

        return $html;
    }
}
