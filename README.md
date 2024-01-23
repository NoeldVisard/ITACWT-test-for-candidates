Для запуска проекта использовать команду **symfony serve**

Пример успешного подсчёта цены:
```
curl --location 'http://127.0.0.1:8000/calculate-price' \
--header 'Content-Type: application/json' \
--data '{
"product": 2,
"taxNumber": "DE123456789",
"couponCode": "D15"
}'
```
Подсчёт цены с ошибкой по валидации taxNumber:
```
curl --location 'http://127.0.0.1:8000/calculate-price' \
--header 'Content-Type: application/json' \
--data '{
    "product": 2,
    "taxNumber": "DE12345678910",
    "couponCode": "D15"
}'
```
Вывод:
```javascript
{
    "errors": {
        "[taxNumber]": [
            "Invalid taxNumber format."
        ]
    }
}
```


Успешное проведение платежа:
```
curl --location 'http://127.0.0.1:8000/purchase' \
--header 'Content-Type: application/json' \
--data '{
"product": 1,
"taxNumber": "DE123456789",
"couponCode": "DI15",
"paymentProcessor": "stripe"
}'
```

Проведение платежа с ошибкой:
```
curl --location 'http://127.0.0.1:8000/purchase' \
--header 'Content-Type: application/json' \
--data '{
"product": 2,
"taxNumber": "DE123456789",
"couponCode": "D15",
"paymentProcessor": "stripe"
}'
```
Вывод:
```javascript
{
    "errors": {
        "text": "Payment process failed."
    }
}
```