#!/usr/bin/env python3

import sys
import pathlib

sys.path.insert(0, str(pathlib.Path(__file__).parent))

from base import BaseBot

class PingBot(BaseBot):
    BOT_NAME = "pingbot"
    BOT_DESCRIPTION = "Responds with pong when you say ping"
    BOT_COMMANDS = [
        {"name": "ping", "description": "Say ping, get pong"},
    ]

    def should_handle(self, command, args):
        return command == "ping"

    def handle(self, command, args, raw_args, message, thread_context):
        return "pong"

if __name__ == "__main__":
    bot = PingBot()
    bot.connect()
