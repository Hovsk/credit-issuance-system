<?php

namespace App\Tests\Service\LoanRules;

use App\Entity\Address;
use App\Entity\Client;
use App\Enum\Region;
use App\Service\LoanRules\AgeRangeRule;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AgeRangeRuleTest extends TestCase
{
    #[DataProvider('provideClients')]
    public function testAgeRangeRule(int $age, bool $expected): void
    {
        $client = new Client(
            pin: '123-45-6789',
            name: 'Test User',
            age: $age,
            address: new Address('Prague', Region::PRAGUE),
            income: 2000,
            score: 600,
            email: 'test@example.com',
            phone: '+420000000000'
        );

        $rule = new AgeRangeRule();
        $this->assertSame($expected, $rule->passes($client));
    }

    public static function provideClients(): \Generator
    {
        yield 'too young' => [17, false];
        yield 'middle age' => [35, true];
        yield 'too old' => [61, false];
    }
}
