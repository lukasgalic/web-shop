#!/bin/bash


# checke if /tmp/simpleBlockchain exists
if [ ! -d "/tmp/simpleBlockchain" ]; then
  # clone it there
  git clone https://github.com/tn606024/simpleBlockchain.git /tmp/simpleBlockchain
  cp ./existingWallets/* /tmp/simpleBlockchain/
fi

cd /tmp/simpleBlockchain

go mod tidy
go build ./cmd/cli

# run alice and the bank

# the node ports are hard-coded inside the simpleblockchain to be 3000 and 3001
# since the 80* are already used by the frontend, we use 7080 and 7081
./cli server start -nodeport 3000 -apiport 7080 -walletname bank -ismining=false &
server_1_id=$!
./cli server start -nodeport 3001 -apiport 7081 -walletname alice -ismining=true &
server_2_id=$!


# wait until the user presses ctrl+c and then kill both servers

trap "kill $server_1_id; kill $server_2_id; exit" INT

wait