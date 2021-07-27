# La Ruche qui dit oui
## _Entretien developpeur Back-end PHP - Gérer des cartes cadeaux_

## Installation

### Database
Change DATABASE_URL in .env file with the right connection values

Run the following commands to create the schema and the tables

```sh
php bin/console doctrine:database:create
php bin/console doctrine:schema:create
```
### Dependencies
Install dependencies
```sh
composer install
```

### Web server
Start a web server to use the application

## API

## Save stock from file
* ### URL ###
    /api/stock
* ### Method ###
    `POST`
* ### Files ###
    CSV file with stock data
* ### Success Response ###
    - Code: 201
    - Content `{
    "status": "ok"
}`
* ### Success Response with errors ###
    - Code: 201
    - Content `{
    "status": "finished with errors",
    "error": [
        "Exception saving element of class App\\Entity\\Receiver. Element with id: c45b8c56-4957-43ff-bd2b-5c5e2f701aeb already exists in DB",
        "Exception saving element of class App\\Entity\\Gift. Element with id: ddb13ad1-18c5-47eb-9a1b-7dfdaf6355f2 already exists in DB"
    ]
}`
 * ### Error Response ###
    - Code: 400
    - Content `{
    "error": "no stock file"
}`

## Get stock statistics
* ### URL ###
    /api/stock/statistics
* ### Method ###
    `GET`
* ### Success Response ###
    - Code: 200
    - Content `[
    {
        "StockId": 6,
        "GiftCount": 3,
        "DifferentCountriesCount": 3,
        "AveragePrice": "43.27666666666667",
        "MaxPrice": "90.45",
        "MinPrice": "15.23"
    },
    {
        "StockId": 7,
        "GiftCount": 988,
        "DifferentCountriesCount": 117,
        "AveragePrice": "48.95149797570854",
        "MaxPrice": "99.88",
        "MinPrice": "0.08"
    }
]`


## Testing

### Database

Run the following commands to create the schema and the tables for testing

```sh
php bin/console --env=test doctrine:database:create
php bin/console --env=test doctrine:schema:create
```
### Test Execution

```sh
php bin/phpunit
```
