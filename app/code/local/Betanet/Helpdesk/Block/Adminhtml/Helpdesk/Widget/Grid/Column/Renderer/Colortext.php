<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Widget_Grid_Column_Renderer_Colortext extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Longtext
{
    /**
     * {@inheritdoc}
     *
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $style = 'text-transform:uppercase;font-size:80%;margin:2px;min-width:80px;text-align:center;font-weight:700; color:#fff; background-color: #'
            . $row->getColor() . '; border: 1px solid #'
            . $row->getColor() . '; padding:1px 5px; display: inline-block;border-radius: 4px';

        return '<span style="'.$style.'">' . parent::render($row) . '</span>';
    }
}
