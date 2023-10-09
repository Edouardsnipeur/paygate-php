# PAYGATE PAYGATEGLOBAL PHP-SDK

## Raw Files

```bash
    git clone https://github.com/Edouardsnipeur/paygate-php.git
```


 
## Installing

  

Using composer:
  

```bash

    composer require paygateglobal/paygate-php

```

## Initialization

#### Production
```php
    $paygate = new \Paygate\Paygate($auth_token);
```
  

## Request to schedule payout 

#### EXAMPLE API Method

```php
    
    // Example to schedule payout API Method
    $response = $paygate->payNow(
        phone_number : "99000000",
        amount : 1000,
        identifier : "993",
        network : \Paygate\Network::FLOOZ
    );

    // Example to schedule payout redirect Method
    $response = $paygate->payNow(
        phone_number : "99000000",
        amount : 1000,
        identifier : "993",
        network : \Paygate\Network::FLOOZ
    );
        
```
#### EXAMPLE redirect Method

```php
    // Example to schedule payout redirect Method
    $response = $paygate->redirectPayNow(
        phone_number : "99000000",
        amount : 1000,
        identifier : "993",
        identifier : "http://exemple.com"
    );
        
```

| PARAMETERS      | DESCRIPTION             |
| ----------- | ----------------------- |
| phone_number    | Numéro de téléphone mobile du Client |
| amount      | Montant de la transaction sans la devise (Devise par défaut: FCFA)                   |
| identifier    | Identifiant interne de la transaction de l’e-commerce. Cet identifiant doit etre unique.              |
| network |  valeurs possibles: ```php \Paygate\Network::FLOOZ```, ```php \Paygate\Network::TMONEY``` |
| url |  Lien de la page vers laquelle le client sera redirigé après le paiement |

#### TRANSACTION $response Object
| Nom      | DESCRIPTION             |
| ----------- | ----------------------- |
|  tx_reference    |        Identifiant Unique générée par PayGateGlobal pour la transaction                |
| status      |         Code d’état de la transaction.               |


## TRANSACTION POSSIBLE STATUS LIST

| STATUS      | DESCRIPTION             |
| ----------- | ----------------------- |
|  SUCCESS    |        Transaction enregistrée avec succès                 |
| INVALID_TOKEN      |         Jeton d’authentification invalide                |
| INVALID_PARAMS    | Paramètres Invalides              |
| DOUBLONS | This transaction  are already reverted or are not eligible                    |
| INTERNAL_ERROR | Doublons détectées. Une transaction avec le même identifiant existe déja.                    |



#### TRANSACTION VERIFICATION EXAMPLE

```php
switch ($response->status) {
    case \Paygate\TransactionStatus::SUCCESS
        //...
        break;
    case \Paygate\TransactionStatus::INVALID_TOKEN:
        //...
        break;
    case \Paygate\TransactionStatus::INVALID_PARAMS:
        //...
        break;
    case \Paygate\TransactionStatus::DOUBLONS:
        //...
        break;
    case \Paygate\TransactionStatus::INTERNAL_ERROR:
        //...
        break;
}
        
```

## Request to retrieve transactions 

#### EXAMPLE
```php
    // Verification with Paygate reference code
    $reponse = $paygate->verifyTransactionWithPaygateReference($tx_reference);

    // Verification with Ecommerce identifier
    $reponse = $paygate->verifyTransactionWithEcommerceId($identifier);
```

| PARAMETERS      | DESCRIPTION             |
| ----------- | ----------------------- |
| tx_reference      | Identifiant Unique générée par PayGateGlobal pour la transaction                   |
| identifier    | Identifiant Unique précédemment généré par l'Ecommerçant pour la transaction             |

#### TRANSACTION $response Object
| Nom      | DESCRIPTION             |
| ----------- | ----------------------- |
|  tx_reference    |       Identifiant Unique généré par PayGateGlobal pour la transaction                |
| identifier      |         Identifiant interne de la transaction de l’e-commerce. ex: Numero de commande Cet identifiant doit etre unique.               |
|  payment_reference    |        Code de référence de paiement généré par Flooz/TMoney. Ce code peut être utilisé en cas de résolution de problèmes ou de plaintes.                |
| status      |         Code d’état du paiement.               |
|  datetime    |        Date et Heure du paiement                |
| payment_method      |        Méthode de paiement utilisée par le client. Valeurs possibles: FLOOZ, T-Money               |


## PAYMENT POSSIBLE STATUS LIST

| STATUS      | DESCRIPTION             |
| ----------- | ----------------------- |
|  SUCCESS    |        Paiement réussi avec succès                 |
| PENDING      |          En cours                |
| EXPIRED    | Expiré              |
| CANCELED | Annulé                    |


#### TRANSACTION VERIFICATION EXAMPLE

```php
switch ($response->status) {
    case \Paygate\PaiementStatus::SUCCESS
        //...
        break;
    case \Paygate\PaiementStatus::PENDING:
        //...
        break;
    case \Paygate\PaiementStatus::EXPIRED:
        //...
        break;
    case \Paygate\PaiementStatus::CANCELED:
        //...
        break;
}
```