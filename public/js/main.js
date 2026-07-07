document.addEventListener('DOMContentLoaded', function() {
    const containers = document.querySelectorAll('.container');
    const totalPriceInput = document.getElementById('totalPrice');
    const totalsumma = document.getElementById('total');
    const dostavkaInput = document.getElementById('dostavka');
    const moreInput = document.getElementById('more');

    function updateTotal() {
        let subtotal = 0;
        let deliveryCost = 1000;

        // Расчет базовой суммы
        containers.forEach(container => {
            const priceElement = container.querySelector('.price');
            const quantityInput = container.querySelector('.quantity');
            const price = parseFloat(priceElement.dataset.price);
            const quantity = parseInt(quantityInput.value);
            subtotal += price * quantity;
        });

        // Определение стоимости доставки
        if (subtotal >= 3000) {
            deliveryCost = 0;
            dostavkaInput.innerHTML = "Доставка беплатно.";
            moreInput.innerHTML = "";
        } else {
            
            dostavkaInput.innerHTML = "Доставка: 1000 ₽";
            moreInput.innerHTML = "Еще " + (3000 - subtotal) + " ₽ для бесплатной доставки.";
        }

        // Расчет общей суммы с учетом доставки
        const total = subtotal + deliveryCost;
        totalsumma.value = total.toFixed(2);
        totalPriceInput.innerHTML = "Итого: " + total.toFixed(2) + " ₽";
    }

    function persistQuantity(container, quantityInput) {
        const updateUrl = container.dataset.updateUrl;
        if (!updateUrl) {
            return;
        }
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        fetch(updateUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: 'count=' + encodeURIComponent(quantityInput.value),
        });
    }

    // Обработчики событий остаются без изменений
    containers.forEach(container => {
        const quantityInput = container.querySelector('.quantity');
        const minusButton = container.querySelector('.number-minus');
        const plusButton = container.querySelector('.number-plus');
        const maxQuantity = parseInt(quantityInput.max) || Infinity;

        quantityInput.addEventListener('change', () => {
            if (parseInt(quantityInput.value) > maxQuantity) {
                quantityInput.value = maxQuantity;
            }
            updateTotal();
            persistQuantity(container, quantityInput);
        });
        minusButton.addEventListener('click', () => {
            quantityInput.stepDown();
            updateTotal();
            persistQuantity(container, quantityInput);
        });
        plusButton.addEventListener('click', () => {
            if (parseInt(quantityInput.value) < maxQuantity) {
                quantityInput.stepUp();
            }
            updateTotal();
            persistQuantity(container, quantityInput);
        });
    });

    updateTotal();
});
       function updateDateTimeSlots() {
            const dateInput = document.getElementById('date');
            const timeSelect = document.getElementById('time');
            
            // Получаем текущую дату и время
            const now = new Date();
            
            // Устанавливаем минимальную дату как сегодняшнюю
            const minDate = now.toISOString().split('T')[0];
            dateInput.min = minDate;
            
            // Получаем выбранную дату
            const selectedDate = dateInput.value ? new Date(dateInput.value) : null;
            
            // Если выбрана дата
            if (selectedDate) {
                const isToday = selectedDate.toDateString() === now.toDateString();
                
                Array.from(timeSelect.options).forEach(option => {
                    if (option.value !== '') { // Пропускаем пустой вариант
                        const [startHour] = option.value.split('-')[0].split(':');
                        
                        // Для сегодняшней даты блокируем время раньше текущего + 2 часа
                        if (isToday) {
                            const hours = now.getHours();
                            const minutes = now.getMinutes();
                            
                            // Если минуты больше 30, считаем следующий час
                            const currentTime = minutes > 30 ? hours + 1 : hours;
                            const minAllowedTime = Math.max(0, currentTime + 1);
                            
                            option.disabled = parseInt(startHour) < minAllowedTime;
                        } else {
                            // Для других дат все времена доступны
                            option.disabled = false;
                        }
                    }
                });
            }
        }

        // Обновляем при загрузке и каждую минуту
        updateDateTimeSlots();
        setInterval(updateDateTimeSlots, 60000);

        // Обновляем при изменении даты или времени
        document.getElementById('date').addEventListener('change', updateDateTimeSlots);
        document.getElementById('time').addEventListener('change', updateDateTimeSlots);