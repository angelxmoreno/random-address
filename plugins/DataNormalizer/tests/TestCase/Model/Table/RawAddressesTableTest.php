<?php
namespace DataNormalizer\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DataNormalizer\Model\Table\RawAddressesTable;

/**
 * DataNormalizer\Model\Table\RawAddressesTable Test Case
 */
class RawAddressesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DataNormalizer\Model\Table\RawAddressesTable
     */
    public $RawAddresses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.data_normalizer.raw_addresses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RawAddresses') ? [] : ['className' => RawAddressesTable::class];
        $this->RawAddresses = TableRegistry::getTableLocator()->get('RawAddresses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RawAddresses);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
