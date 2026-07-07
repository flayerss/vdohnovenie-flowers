<x-mail::message>
# Заказ №{{ $order->id }} принят

Здравствуйте, {{ $order->name }}!

Ваш заказ принят и будет доставлен в указанное вами время:

<x-mail::table>
| Поле | Значение |
| :- | :- |
| Адрес доставки | {{ $order->dostavka }} |
| Дата | {{ $order->date }} |
| Время | {{ $order->time }} |
</x-mail::table>

Спасибо,<br>
{{ config('app.name') }}
</x-mail::message>
