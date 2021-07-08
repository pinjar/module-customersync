<?php

namespace Tfscommerce\Customersync\Ui\Component\Listing\Column;

class Request extends \Magento\Ui\Component\Listing\Columns\Column
{

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
    if (isset($dataSource['data']['items'])) 
        {
            foreach ($dataSource['data']['items'] as & $item) 
            {
                //DO SOMETHING WITH THE ITEM
                if($item['request'] !== "")
                {
						
						if(strlen($item['request']) >= 60 )
						{
                           $item['request'] = substr($item['request'], 0, 50)."..........";
						}
						else
						{
							$item['request'] = substr($item['request'], 0, 60);
						} 
                   
                }
            }
        }
        return $dataSource;
    }
}