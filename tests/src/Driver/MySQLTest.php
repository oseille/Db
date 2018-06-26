<?php

namespace OphpTest\Db\Driver;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-04-18 at 21:21:13.
 */
class MySQLTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Database configuration
     * @var array
     */
    public static $aDBConfig = NULL;

    /**
     * Database names
     * @var string
     */
    public static $sDBName = NULL;

    /**
     * Server configuration
     * @var array
     */
    public static $aServer = NULL;

    /**
     * Credentials
     * @var array
     */
    public static $aCredentials = NULL;

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function setUpBeforeClass()
    {
        $sConfig = APPLICATION_PATH_CONFIG . \DIRECTORY_SEPARATOR . 'config.php';
        static::$aDBConfig = include realpath($sConfig);
        static::$sDBName = static::$aDBConfig['database']['dbnames']['test'];
        static::$aServer = static::$aDBConfig['database']['servers']['local'];
        static::$aCredentials = static::$aDBConfig['database']['users'];
    }

    /**
     * @covers \Ophp\Db\Driver\MySQL
     * @uses   \Ophp\Db\Driver\Parameters\Parameters
     * @uses   \Ophp\Db\Driver\Parameters\Credentials
     * @group specification
     * @expectedException \RuntimeException
     */
    public function testConstructRuntimeException()
    {
        $pParameter = new \Ophp\Db\Driver\Parameters\Parameters();
        $pCredential = new \Ophp\Db\Driver\Parameters\Credentials();
        $pDriver = new \Ophp\Db\Driver\MySQL(
            $pParameter,
            $pCredential
        );
    }

    /**
     * @covers \Ophp\Db\Driver\MySQL
     * @uses   \Ophp\Db\Driver\Parameters\Parameters
     * @uses   \Ophp\Db\Driver\Parameters\Credentials
     * @group specification
     */
    public function testConstruct()
    {
        $pParameter = new \Ophp\Db\Driver\Parameters\Parameters();
        $this->assertTrue($pParameter->setParameters(static::$aServer)->setDBName(static::$sDBName)->valid());

        $path = APPLICATION_PATH_CONFIG . \DIRECTORY_SEPARATOR . 'db.credential.php';
        $pCredential = new \Ophp\Db\Driver\Parameters\Credentials();
        $this->assertTrue($pCredential->setCredential(
            $path,
            'super'
        )->valid());

        $pDriver = new \Ophp\Db\Driver\MySQL(
            $pParameter,
            $pCredential
        );
        $this->assertTrue($pDriver instanceof \PDO);

        $this->assertSame(
            static::$sDBName,
            $pDriver->getDBName()
        );

        $pDriver = null;

        unset($pCredential,
            $pParameter);
    }


    /**
     * @covers \Ophp\Db\Driver\MySQL
     * @group specification
     */
    public function testCheckColumnNames()
    {
        // not same count
        $this->assertFalse( \Ophp\Db\Driver\MySQL::checkColumnNames( [], ['a','b']) );
        $this->assertFalse( \Ophp\Db\Driver\MySQL::checkColumnNames( ['a'=>1], ['a','b']) );
        $this->assertFalse( \Ophp\Db\Driver\MySQL::checkColumnNames( ['a'=>1,'b'=>1,'c'=>1], ['a','b']) );

        // not same value
        $this->assertFalse( \Ophp\Db\Driver\MySQL::checkColumnNames( ['a'=>1,'d'=>1], ['a','b']) );

        // ok
        $this->assertTrue( \Ophp\Db\Driver\MySQL::checkColumnNames( ['a'=>1,'b'=>1], ['a','b']) );
    }
}