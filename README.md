A repo for creating a php web server using Docker

Start service by _running docker compose up -d_ in the root folder 


# reset db

The db is a docker volume, these are located at `/var/lib/docker/volumes' (on linux).
Do not remove these manually!
Use `docker volume rm web-security_db_data` instead.
After removing it and rebooting the container it should be inited with our initial datasets.


# The blockchain:

## general note:
It is not possible to change the position of some config/wallet files for the software used. I am using [simpleBlockchain](https://github.com/tn606024/simpleBlockchain.git).

I tried setting this up with containers but sadly that is simply not possible, the go server is too simplistic to handle dockers containment and is stuck inside since the requests go against 'localhost' which is unknown from gos' point of view.

Instead everything is setup inside `blockchain/setupBlockChain.sh`.

It also starts two node instances.
To shutdown the server run: `killall cli` which should then stop them.

The script should take care of that tho, ctrl+c to kill both servers

## setup
The server runs 2 nodes, alice and the bank.
Only alice is allowed to mine for coins.

### Alice

nodeport: 7001
apiport: 7081  < This one is used for all the 'commands'

Sending money from alice to the bank:
```bash
./cli server sendtransaction --apiport 7081 --to "1LHroFft5WAxZTqXizQJjBJrPwkVQFAcsa" -amount 100000
```

### Commands
Mining:
```bash
./cli server miningblock --apiport <apiport>
```
This will mine whatever value the block currently has into the wallet that is running there. The database is not updated.

Getting the wallet address:
```bash
./cli server getwalletaddress -apiport <apiport>
```

Wallet balance:
```bash
./cli server getwalletbalance -apiport <apiport>
```
