<?php

namespace Tests\Feature;

use App\Http\Middleware\EncryptCookies;
use App\Models\Product;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Status::insert([
            ['id' => 1, 'name' => 'Новый'],
            ['id' => 2, 'name' => 'Отказан'],
            ['id' => 3, 'name' => 'Одобрен'],
        ]);
        // Отключаем шифрование cookie, чтобы вручную переносить session id
        // между отдельными вызовами внутри теста (иначе каждый запрос получает
        // новую сессию и корзина "теряется" между шагами сценария).
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

    public function test_order_is_created_from_basket_and_stock_is_decremented(): void
    {
        Mail::fake();

        $type = Type::create(['name' => 'Букеты']);
        $product = Product::create([
            'img' => '/img/test.jpg',
            'name' => 'Тестовый букет',
            'price' => 1500,
            'count' => 5,
            'type_id' => $type->id,
        ]);

        $response = $this->get('/corsina/add/' . $product->id);
        $this->carrySessionCookie($response);
        $response = $this->get('/corsina/add/' . $product->id);
        $this->carrySessionCookie($response);

        $response = $this->post('/order', [
            'name' => 'Иван Иванов',
            'phone' => '+79991234567',
            'email' => 'ivan@example.com',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '10:00-11:00',
            'address' => 'ул. Тестовая, 1',
            'type' => 'Наличные',
        ]);

        $response->assertRedirect(route('corsina'));

        $this->assertDatabaseHas('orders', [
            'name' => 'Иван Иванов',
            'email' => 'ivan@example.com',
            'status_id' => 1,
        ]);

        $product->refresh();
        $this->assertEquals(3, $product->count);
    }

    public function test_order_fails_when_stock_is_insufficient(): void
    {
        Mail::fake();

        $type = Type::create(['name' => 'Букеты']);
        $product = Product::create([
            'img' => '/img/test.jpg',
            'name' => 'Дефицитный букет',
            'price' => 1500,
            'count' => 3,
            'type_id' => $type->id,
        ]);

        $response = $this->get('/corsina/add/' . $product->id);
        $this->carrySessionCookie($response);
        $response = $this->get('/corsina/add/' . $product->id);
        $this->carrySessionCookie($response);

        // Остаток закончился уже после того, как товар положили в корзину
        // (например, его раскупили в другой сессии) — заказ должен это поймать.
        $product->update(['count' => 1]);

        $response = $this->post('/order', [
            'name' => 'Иван Иванов',
            'phone' => '+79991234567',
            'email' => 'ivan@example.com',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '10:00-11:00',
            'address' => 'ул. Тестовая, 1',
            'type' => 'Наличные',
        ]);

        $response->assertSessionHasErrors('error');
        $this->assertDatabaseCount('orders', 0);

        $product->refresh();
        $this->assertEquals(1, $product->count);
    }
}
