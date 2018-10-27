<?php
namespace DataNormalizer\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DataNormalizer\Model\Table\CompiledAddressesTable;

/**
 * DataNormalizer\Model\Table\CompiledAddressesTable Test Case
 */
class CompiledAddressesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DataNormalizer\Model\Table\CompiledAddressesTable
     */
    public $CompiledAddresses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.data_normalizer.compiled_addresses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CompiledAddresses') ? [] : ['className' => CompiledAddressesTable::class];
        $this->CompiledAddresses = TableRegistry::getTableLocator()->get('CompiledAddresses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CompiledAddresses);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
