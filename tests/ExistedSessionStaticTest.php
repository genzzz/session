<?php
use PHPUnit\Framework\TestCase;

use Genzzz\Session\Session;

class ExistedSessionStaticTest extends TestCase
{
    public function test_init_existed_session()
    {
        $this->assertEmpty(session_id());
        session_start();
        $this->assertNotEmpty(session_id());

        $_SESSION = [
            'testkey' => 'testvalue',
            'newkey' => 'newvalue'
        ];
    }

    public function test_all_function()
    {
        $this->assertNotNull(Session::all());
        $this->assertCount(2, Session::all());
    }

    public function test_get_function()
    {
        $this->assertSame(Session::get('newkey'), 'newvalue');
        $this->assertSame(Session::get('testkey'), 'testvalue');
    }

    public function test_add_function()
    {
        Session::add('key1', 'value1');
        $this->assertArrayHasKey('key1', Session::all());
        Session::add('key2', 'value2');
        $this->assertArrayHasKey('key2', Session::all());
    }

    public function test_exists_function()
    {
        $this->assertTrue(Session::exists('newkey'));
        $this->assertFalse(Session::exists('anotherkey'));
    }

    public function test_set_function()
    {
        Session::set('newkey', 'newnewvalue');
        $this->assertSame(Session::get('newkey'), 'newnewvalue');

        Session::set('anotherkey', 'anothervalue');
        $this->assertSame(Session::get('anotherkey'), 'anothervalue');
    }

    public function test_has_function()
    {
        $this->assertTrue(Session::has('newkey'));
        $this->assertFalse(Session::has('bestkey'));

        Session::add('bestkey', null);
        $this->assertFalse(Session::has('bestkey'));
    }

    public function test_remove_function()
    {
        // remove single key
        Session::remove('newkey');
        $this->assertArrayNotHasKey('newkey', Session::all());

        // remove multiple keys
        Session::remove(['key1', 'key2']);
        $this->assertArrayNotHasKey('key1', Session::all());
        $this->assertArrayNotHasKey('key2', Session::all());
    }

    public function test_remove_except_function()
    {
        Session::add('key1', 'value1');
        Session::add('key2', 'value2');

        Session::remove_except(['testkey', 'anotherkey']);
        $this->assertArrayHasKey('testkey', Session::all());
        $this->assertArrayHasKey('anotherkey', Session::all());

        $this->assertArrayNotHasKey('key1', Session::all());
        $this->assertArrayNotHasKey('key2', Session::all());
    }

    public function test_remove_only_function()
    {
        Session::add('key1', 'value1');
        Session::add('key2', 'value2');

        Session::remove_only(['key1', 'key2']);
        $this->assertArrayNotHasKey('key1', Session::all());
        $this->assertArrayNotHasKey('key2', Session::all());

        $this->assertArrayHasKey('testkey', Session::all());
        $this->assertArrayHasKey('anotherkey', Session::all());
    }

    public function test_flash_function()
    {
        $flash = Session::flash('anotherkey');

        $this->assertSame($flash, 'anothervalue');
        $this->assertArrayNotHasKey('anotherkey', Session::all());
    }

    public function test_clear_function()
    {
        Session::clear();
        $this->assertEmpty(Session::all());
    }
}