<?php
namespace DataNormalizer\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DataNormalizer\Model\Table\BadAddressesTable;

/**
 * DataNormalizer\Model\Table\BadAddressesTable Test Case
 */
class BadAddressesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DataNormalizer\Model\Table\BadAddressesTable
     */
    public $BadAddresses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.data_normalizer.bad_addresses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BadAddresses') ? [] : ['className' => BadAddressesTable::class];
        $this->BadAddresses = TableRegistry::getTableLocator()->get('BadAddresses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BadAddresses);

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
