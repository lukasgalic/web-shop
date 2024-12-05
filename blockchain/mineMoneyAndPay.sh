#!/bin/bash



# Mine money for alice
curl -i -X GET \
 'http://localhost:7080/chain/mining'


# transfer an amount of money to the given address
curl -i -X POST \
   -H "Content-Type:application/json" \
   -d \
        '{
        "To": "1LHroFft5WAxZTqXizQJjBJrPwkVQFAcsa",
        "Amount": 200
        }' \
 'http://localhost:7080/wallet/send'

