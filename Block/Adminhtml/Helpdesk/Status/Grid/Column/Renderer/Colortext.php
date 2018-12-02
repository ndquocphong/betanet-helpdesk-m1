<?php

class Betanet_HelpDesk_Block_Adminhtml_Helpdesk_Status_Grid_Column_Renderer_Colortext extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Longtext
{
    /**
     * {@inheritdoc}
     *
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $style = 'margin:2px;min-width:100px;text-align:center;font-weight:400; color: #'
            . $row->getColor() . '; border: 1px solid #'
            . $row->getColor() . '; padding:2px 10px; display: inline-block;border-radius: 4px';

        return '<span style="'.$style.'">' . parent::render($row) . '</span>';
    }
}
