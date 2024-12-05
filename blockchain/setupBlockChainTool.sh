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


