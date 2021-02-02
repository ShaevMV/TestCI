#!/bin/bas

#env file
if [ -e $HOME/.env ]
    then
        echo ""
    else
        cp -p $HOME/.env.example $HOME/.env
fi
