<x-mail::message>
# Заказ №{{ $order->id }} отменён

Здравствуйте, {{ $order->name }}!

К сожалению, ваш заказ отменён. Попробуйте оформить его снова.

Спасибо,<br>
{{ config('app.name') }}
</x-mail::message>
