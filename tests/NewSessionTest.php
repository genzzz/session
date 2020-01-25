<?php
use PHPUnit\Framework\TestCase;

use Genzzz\Session\Tests\Classes\NewSession as Session;

class NewSessionTest extends TestCase
{
    public function test_init_session()
    {
        $session = new Session();
        $this->assertInstanceOf(Session::class, $session);

        $this->assertNotNull($session->the_id());
        $this->assertIsString($session->the_id());
        $this->assertEquals(strlen($session->the_id()), 26);

        $this->assertNotNull($session->the_IP());
        $this->assertIsString($session->the_IP());

        $this->assertNull($session->the_serialized_session());

        $this->assertNotNull($session->the_last_activity());
        $this->assertIsInt($session->the_last_activity());

        return $session;
    }

    /**
     * @depends test_init_session
     */
    public function test_all_function(Session $session)
    {
        $this->assertNull($session->all());
    }

    /**
     * @depends test_init_session
     */
    public function test_add_function(Session $session)
    {
        $session->add('newkey', 'newvalue');
        $this->assertArrayHasKey('newkey', $session->all());

        $session->add('key1', 'value1');
        $this->assertArrayHasKey('key1', $session->all());
        $session->add('key2', 'value2');
        $this->assertArrayHasKey('key2', $session->all());
    }

    /**
     * @depends test_init_session
     */
    public function test_get_function(Session $session)
    {
        $this->assertSame($session->get('newkey'), 'newvalue');
        $this->assertSame($session->get('key1'), 'value1');
        $this->assertSame($session->get('key2'), 'value2');
    }

    /**
     * @depends test_init_session
     */
    public function test_exists_function(Session $session)
    {
        $this->assertTrue($session->exists('newkey'));
        $this->assertFalse($session->exists('testkey'));
    }

    /**
     * @depends test_init_session
     */
    public function test_set_function(Session $session)
    {
        $session->set('newkey', 'newnewvalue');
        $this->assertSame($session->get('newkey'), 'newnewvalue');

        $session->set('anotherkey', 'anothervalue');
        $this->assertSame($session->get('anotherkey'), 'anothervalue');
    }

    /**
     * @depends test_init_session
     */
    public function test_has_function(Session $session)
    {
        $this->assertTrue($session->has('newkey'));
        $this->assertFalse($session->has('testkey'));

        $session->add('testkey', null);
        $this->assertFalse($session->has('testkey'));
    }

    /**
     * @depends test_init_session
     */
    public function test_remove_function(Session $session)
    {
        // remove single key
        $session->remove('newkey');
        $this->assertArrayNotHasKey('newkey', $session->all());

        // remove multiple keys
        $session->remove(['key1', 'key2']);
        $this->assertArrayNotHasKey('key1', $session->all());
        $this->assertArrayNotHasKey('key2', $session->all());
    }

    /**
     * @depends test_init_session
     */
    public function test_remove_except_function(Session $session)
    {
        $session->add('key1', 'value1');
        $session->add('key2', 'value2');

        $session->remove_except(['testkey', 'anotherkey']);
        $this->assertArrayHasKey('testkey', $session->all());
        $this->assertArrayHasKey('anotherkey', $session->all());

        $this->assertArrayNotHasKey('key1', $session->all());
        $this->assertArrayNotHasKey('key2', $session->all());
    }

    /**
     * @depends test_init_session
     */
    public function test_remove_only_function(Session $session)
    {
        $session->add('key1', 'value1');
        $session->add('key2', 'value2');

        $session->remove_only(['key1', 'key2']);
        $this->assertArrayNotHasKey('key1', $session->all());
        $this->assertArrayNotHasKey('key2', $session->all());

        $this->assertArrayHasKey('testkey', $session->all());
        $this->assertArrayHasKey('anotherkey', $session->all());
    }

    /**
     * @depends test_init_session
     */
    public function test_flash_function(Session $session)
    {
        $flash = $session->flash('anotherkey');

        $this->assertSame($flash, 'anothervalue');
        $this->assertArrayNotHasKey('anotherkey', $session->all());
    }

    /**
     * @depends test_init_session
     */
    public function test_clear_function(Session $session)
    {
        $session->clear();
        $this->assertNull($session->all());
    }
}