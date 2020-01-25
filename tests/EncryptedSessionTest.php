<?php
use PHPUnit\Framework\TestCase;

use Genzzz\Session\Tests\Classes\EncryptedNewSession as NewSession;
use Genzzz\Session\Tests\Classes\EncryptedExistedSession as ExistedSession;

class EncryptedSessionTest extends TestCase
{
    public function test_new_encrypted_session()
    {
        $session = new NewSession();
        $this->assertInstanceOf(NewSession::class, $session);

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

    public function test_existed_encrypted_session()
    {
        $session = new ExistedSession();
        $this->assertInstanceOf(ExistedSession::class, $session);

        $this->assertNotNull($session->the_id());
        $this->assertIsString($session->the_id());
        $this->assertEquals(strlen($session->the_id()), 26);

        $this->assertNotNull($session->the_IP());
        $this->assertIsString($session->the_IP());

        $this->assertNotNull($session->the_serialized_session());
        $this->assertIsArray(unserialize($session->the_serialized_session()));

        $this->assertNotNull($session->the_last_activity());
        $this->assertIsInt($session->the_last_activity());

        return $session;
    }

    /**
     * @depends test_new_encrypted_session
     */
    public function test_all_function_for_new_session(NewSession $session)
    {
        $this->assertNull($session->all());
    }

    /**
     * @depends test_existed_encrypted_session
     */
    public function test_all_function_for_existed_session(ExistedSession $session)
    {
        $this->assertNotNull($session->all());
    }
}