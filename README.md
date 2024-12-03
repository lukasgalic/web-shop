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

The folder here lists all wallets that have been created, only the ones relevant are copied into each container. Bank gets wallet_bank, etc. The files are volume-linked into the GO executable (where it expects to find them in order to run).

From the containers point of view, there is only ever one wallet inside its execution, you can create a new wallet on whatever api-port you want, doing so will create a file inside a docker container that is **NOT** linked out, meaning its deleted when the container stops. You must copy it out manually but i don't see why you need more wallets.


## setup
The server runs 2 nodes, alice and the bank.
This is not realistic as alice would usually run her node on her own hardware, but since we are dockerizing this and I don't want to deal with y'alls GO configurations, both are running side by side.

The default ports would clash with the webserver, therefore every port has the prefix 70*.
The bank is _not_ allowed to mine.

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
