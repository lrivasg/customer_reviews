<?php
/**
 * Customerreviews installer
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */

$installer = $this;
$installer->startSetup();

    $reviewstable = $installer->getConnection()
        ->newTable($installer->getTable('customerreviews/reviews'))
        ->addColumn('review_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),  'Review id')
        ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ), 'Order id')
        ->addColumn('review_status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'default' => 1
        ),  'Review status')
        ->addColumn('date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'nullable'  => false
        ),  'Review creation time')
        ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false
        ),  'User name')
        ->addColumn('email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false
        ),  'User email')
        ->addColumn('rating_delivery', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(),
            'Delivey')
        ->addColumn('rating_product', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(),
            'Product(s)')
        ->addColumn('rating_customer_support', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(),
            'Customer support')
        ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false
        ),  'User comments');
    $installer->getConnection()->createTable($reviewstable);

    $reminderstable = $installer->getConnection()
        ->newTable($installer->getTable('customerreviews/reminders'))
        ->addColumn('reminder_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),  'Reminder id')
        ->addColumn('reminder_status', Varien_Db_Ddl_Table::TYPE_TEXT, 127, array(
        ), 'Reminder Status')
        ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ), 'Order id')
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ),  'Customer Id')
        ->addColumn('customer_email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ),  'Customer Email')
        ->addColumn('sent_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default'   => NULL,
        ),  'Reminder sent time')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default'   => NULL,
        ),  'Creation Time')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default'   => NULL,
        ),  'Update Time');
    $installer->getConnection()->createTable($reminderstable);

$installer->endSetup();

