<?php

namespace Tests\Feature;

use App\Http\Middleware\EncryptCookies;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasketIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Отключаем шифрование cookie, чтобы вручную переносить session id
        // между запросами внутри одной "вкладки браузера" (см. пояснение в OrderTest).
        $this->withoutMiddleware(EncryptCookies::class);
        $this->encryptCookies = false;
    }

    private function carrySessionCookie($response): void
    {
        $cookieName = config('session.cookie');
        foreach ($response->headers->getCookies() as $cookie) {
            if ($cookie->getName() === $cookieName) {
                $this->withCookie($cookieName, $cookie->getValue());
            }
        }
    }

    public function test_two_sessions_do_not_share_a_basket(): void
    {
        $type = Type::create(['name' => 'Букеты']);
        $productA = Product::create([
            'img' => '/img/a.jpg', 'name' => 'Букет A', 'price' => 1000, 'count' => 10, 'type_id' => $type->id,
        ]);
        $productB = Product::create([
            'img' => '/img/b.jpg', 'name' => 'Букет B', 'price' => 2000, 'count' => 10, 'type_id' => $type->id,
        ]);

        // Вкладка №1: кладёт в корзину товар A
        $response = $this->get('/corsina/add/' . $productA->id);
        $this->carrySessionCookie($response);
        $cartPage1 = $this->get('/corsina');
        $cartPage1->assertSee('Букет A');
        $cartPage1->assertDontSee('Букет B');

        // Сбрасываем cookie — имитируем другого посетителя (вкладка №2, без общих cookie)
        $this->defaultCookies = [];

        // Вкладка №2: кладёт в корзину товар B
        $response = $this->get('/corsina/add/' . $productB->id);
        $this->carrySessionCookie($response);
        $cartPage2 = $this->get('/corsina');
        $cartPage2->assertSee('Букет B');
        $cartPage2->assertDontSee('Букет A');

        $this->assertDatabaseCount('baskets', 2);
    }
}
