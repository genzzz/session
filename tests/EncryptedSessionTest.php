<?php
// use PHPUnit\Framework\TestCase;

// use Genzzz\Session\Tests\EncryptedNewSession as NewSession;
// use Genzzz\Session\Tests\EncryptedExistedSession as ExistedSession;

// class EncryptedSessionTest extends TestCase
// {
//     public function test_new_encrypted_session()
//     {
//         $session = new NewSession();
//         $this->assertInstanceOf(NewSession::class, $session);

//         $this->assertNotNull($session->get_the_id());
//         $this->assertIsString($session->get_the_id());
//         $this->assertEquals(strlen($session->get_the_id()), 26);

//         $this->assertNotNull($session->get_the_ip());
//         $this->assertIsString($session->get_the_ip());

//         $this->assertNull($session->the_serialized_session());

//         $this->assertNotNull($session->the_last_activity());
//         $this->assertIsInt($session->the_last_activity());

//         return $session;
//     }

//     public function test_existed_encrypted_session()
//     {
//         $session = new ExistedSession();
//         $this->assertInstanceOf(ExistedSession::class, $session);

//         $this->assertNotNull($session->get_the_id());
//         $this->assertIsString($session->get_the_id());
//         $this->assertEquals(strlen($session->get_the_id()), 26);

//         $this->assertNotNull($session->get_the_ip());
//         $this->assertIsString($session->get_the_ip());

//         $this->assertNotNull($session->the_serialized_session());
//         $this->assertIsArray(unserialize($session->the_serialized_session()));

//         $this->assertNotNull($session->the_last_activity());
//         $this->assertIsInt($session->the_last_activity());

//         return $session;
//     }

//     /**
//      * @depends test_new_encrypted_session
//      */
//     public function test_all_function_for_new_session(NewSession $session)
//     {
//         $this->assertNull($session->all());
//     }

//     /**
//      * @depends test_existed_encrypted_session
//      */
//     public function test_all_function_for_existed_session(ExistedSession $session)
//     {
//         $this->assertNotNull($session->all());
//     }
// }