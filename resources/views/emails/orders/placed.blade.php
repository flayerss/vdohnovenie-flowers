<x-mail::message>
# Заказ №{{ $order->id }} оформлен

Здравствуйте, {{ $order->name }}!

Спасибо за заказ в нашем цветочном магазине. Вот его детали:

<x-mail::table>
| Поле | Значение |
| :- | :- |
| Адрес доставки | {{ $order->dostavka }} |
| Дата | {{ $order->date }} |
| Время | {{ $order->time }} |
| Способ оплаты | {{ $order->type_oplata }} |
</x-mail::table>

Мы свяжемся с вами по номеру {{ $order->phone }}, чтобы подтвердить заказ.

Спасибо,<br>
{{ config('app.name') }}
</x-mail::message>
