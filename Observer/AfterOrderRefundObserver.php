<?php
namespace Informatics\Refundstatus\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Sales creditmemo save after observer
 */
class AfterOrderRefundObserver implements ObserverInterface 
{

    /**
    * @var \Magento\Sales\Model\OrderRepository
    */
    public $_orderRepository;


    public function __construct(
        \Magento\Sales\Model\OrderRepository $orderRepository
    )
    {       
        $this->_orderRepository = $orderRepository;
    }

    /**
     * Update the order status after creditmemo saved
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $creditmemo = $observer->getEvent()->getCreditmemo();
        $order      = $creditmemo->getOrder();

        $order->setState(\Magento\Sales\Model\Order::STATE_CLOSED, true);
        $order->setStatus('closed');
        $this->_orderRepository->save($order);
    }
}