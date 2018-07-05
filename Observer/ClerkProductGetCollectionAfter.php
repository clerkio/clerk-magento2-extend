<?php

namespace Clerk\ExtendClerk\Observer;

class ClerkProductGetCollectionAfter implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $adapter = $observer->getEvent()->getAdapter();
        $collection = $observer->getEvent()->getCollection();

        /**
         * Add field handler for price ex vat
         */
        $adapter->addFieldHandler('price_ex_vat', function($item) {
            /** @var \Magento\Catalog\Model\Product $item */
            try {
                $price = $item->getPriceInfo()->getPrice('final_price')->getAmount()->getBaseAmount();
                return (float) $price;
            } catch(\Exception $e) {
                return 0;
            }
        });

        $adapter->addField('price_ex_vat');
    }
}