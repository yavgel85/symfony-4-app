<?php

namespace App\Tests\Security;

use App\Security\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{
    public function testTokenGeneration(): void
    {
        $tokenGenerator = new TokenGenerator();
        $token = $tokenGenerator->getRandomSecureToken(30);

        $this->assertEquals(30, \strlen($token));
        $this->assertTrue(ctype_alnum($token), 'Token contains incorrect characters');
    }
}