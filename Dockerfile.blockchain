FROM golang:1.23

WORKDIR /app

RUN git clone https://github.com/ZweiEuro/simpleBlockchain


WORKDIR /app/simpleBlockchain
# download dependencies

RUN go mod tidy

RUN go build ./cmd/cli
