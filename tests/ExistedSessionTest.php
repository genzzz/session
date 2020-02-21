<?php
use PHPUnit\Framework\TestCase;

use Genzzz\Session\SessionFunctions;

class ExistedSessionTest extends TestCase
{
    public function test_init_existed_session()
    {
        $this->assertEmpty(session_id());
        session_start();
        $this->assertNotEmpty(session_id());

        $GLOBALS['genzzz_sess' . session_id()] = new SessionFunctions();
        $this->assertArrayHasKey('genzzz_sess'. session_id(), $GLOBALS);

        $_SESSION = [
            'testkey' => 'testvalue',
            'newkey' => 'newvalue'
        ];
    }

    public function test_all_function()
    {
        $this->assertNotNull(session()->all());
        $this->assertCount(2, session()->all());
    }

    public function test_get_function()
    {
        $this->assertSame(session()->get('newkey'), 'newvalue');
        $this->assertSame(session()->get('testkey'), 'testvalue');
    }

    public function test_add_function()
    {
        session()->add('key1', 'value1');
        $this->assertArrayHasKey('key1', session()->all());
        session()->add('key2', 'value2');
        $this->assertArrayHasKey('key2', session()->all());
    }

    public function test_exists_function()
    {
        $this->assertTrue(session()->exists('newkey'));
        $this->assertFalse(session()->exists('anotherkey'));
    }

    public function test_set_function()
    {
        session()->set('newkey', 'newnewvalue');
        $this->assertSame(session()->get('newkey'), 'newnewvalue');

        session()->set('anotherkey', 'anothervalue');
        $this->assertSame(session()->get('anotherkey'), 'anothervalue');
    }

    public function test_has_function()
    {
        $this->assertTrue(session()->has('newkey'));
        $this->assertFalse(session()->has('bestkey'));

        session()->add('bestkey', null);
        $this->assertFalse(session()->has('bestkey'));
    }

    public function test_remove_function()
    {
        // remove single key
        session()->remove('newkey');
        $this->assertArrayNotHasKey('newkey', session()->all());

        // remove multiple keys
        session()->remove(['key1', 'key2']);
        $this->assertArrayNotHasKey('key1', session()->all());
        $this->assertArrayNotHasKey('key2', session()->all());
    }

    public function test_remove_except_function()
    {
        session()->add('key1', 'value1');
        session()->add('key2', 'value2');

        session()->remove_except(['testkey', 'anotherkey']);
        $this->assertArrayHasKey('testkey', session()->all());
        $this->assertArrayHasKey('anotherkey', session()->all());

        $this->assertArrayNotHasKey('key1', session()->all());
        $this->assertArrayNotHasKey('key2', session()->all());
    }

    public function test_remove_only_function()
    {
        session()->add('key1', 'value1');
        session()->add('key2', 'value2');

        session()->remove_only(['key1', 'key2']);
        $this->assertArrayNotHasKey('key1', session()->all());
        $this->assertArrayNotHasKey('key2', session()->all());

        $this->assertArrayHasKey('testkey', session()->all());
        $this->assertArrayHasKey('anotherkey', session()->all());
    }

    public function test_flash_function()
    {
        $flash = session()->flash('anotherkey');

        $this->assertSame($flash, 'anothervalue');
        $this->assertArrayNotHasKey('anotherkey', session()->all());
    }

    public function test_clear_function()
    {
        session()->clear();
        $this->assertEmpty(session()->all());
    }
}