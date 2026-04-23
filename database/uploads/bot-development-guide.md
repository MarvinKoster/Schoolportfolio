# Bot Development Guide

A comprehensive guide to creating and deploying bots in the MediaMatch chat system.

## Table of Contents

1. [Quick Start](#quick-start)
2. [Bot Architecture](#bot-architecture)
3. [BaseBot Class](#basebot-class)
4. [Creating Your First Bot](#creating-your-first-bot)
5. [Available Utility Methods](#available-utility-methods)
6. [Advanced Topics](#advanced-topics)
7. [Deployment](#deployment)
8. [Testing](#testing)
9. [Examples](#examples)
10. [Troubleshooting](#troubleshooting)

## Quick Start

The fastest way to create a bot:

1. **Create a new bot file** in `bots/my_bot.py`:

```python
#!/usr/bin/env python3
import sys
import pathlib

sys.path.insert(0, str(pathlib.Path(__file__).parent))

from base import BaseBot

class MyBot(BaseBot):
    BOT_NAME = "mybot"
    BOT_DESCRIPTION = "My first bot"
    BOT_COMMANDS = [
        {"name": "hello", "description": "Say hello"},
    ]

    def should_handle(self, command, args):
        return command == "hello"

    def handle(self, command, args, raw_args, message, thread_context):
        return f"Hello {args[0] if args else 'World'}!"

if __name__ == "__main__":
    bot = MyBot()
    bot.connect()
```

2. **Test it locally** (requires running webchat server):

```bash
python bots/my_bot.py
```

3. **Deploy** via docker-compose (see [Deployment](#deployment) section).

## Bot Architecture

### How Bots Connect

```
┌─────────────────────┐
│   Your Bot Process  │
│  (Python script)    │
│                     │
│  1. Create instance │
│  2. Generate JWT    │
│  3. Connect to SIO  │
│  4. Register self   │
│  5. Receive commands│
│  6. Send responses  │
└─────────────────────┘
         │
         │ Socket.IO WebSocket
         │
         ▼
┌─────────────────────┐
│  Webchat Server     │
│  (sioserver.py)     │
│                     │
│  Routes commands    │
│  from users to bots │
└─────────────────────┘
         ▲
         │
         │ Socket.IO
         │
┌─────────────────────┐
│   Browser/Client    │
│                     │
│  @mybot hello World │
└─────────────────────┘
```

### Bot Lifecycle

1. **Instantiation**: `bot = MyBot()`
2. **Connection**: `bot.connect()` - establishes Socket.IO connection
3. **Authentication**: Automatically sends JWT token to server
4. **Registration**: Registers bot metadata (name, description, commands)
5. **Ready**: Waits for incoming commands from users
6. **Respond**: When a command arrives, calls `handle()` method
7. **Broadcast**: Response is sent to all users in the group

### Bot Inheritance Hierarchy

Modern bots can inherit from different base classes:

```
BaseBot (base.py) - Default for all bots
├── ChatBot → LLMBot (llm_bot.py) - Conversational AI bots
├── MediaMatchBot → BaseBot - Search/integration bots  
├── EchoBot → BaseBot - Simple command bots
└── CustomBot → BaseBot - Your custom bot
```

**See:** `rg "^class.*BaseBot" bots/` for all bot implementations

## BaseBot Class

All bots inherit from `BaseBot`. Here's the class structure:

### Required Attributes

```python
class MyBot(BaseBot):
    # Unique identifier for the bot (used in @botname syntax)
    BOT_NAME = "mybot"
    
    # Description shown to users
    BOT_DESCRIPTION = "A brief description of what this bot does"
    
    # List of commands this bot understands
    BOT_COMMANDS = [
        {"name": "command1", "description": "What command1 does"},
        {"name": "command2", "description": "What command2 does"},
    ]
```

### Required Methods

Every bot must implement two methods:

#### `should_handle(command: str, args: List[str]) -> bool`

Determines if this bot should handle a given command.

```python
def should_handle(self, command, args):
    return command in ["search", "find", "help"]
```

**Parameters:**
- `command`: The command name (first word after @botname)
- `args`: Parsed arguments (shell-quoted, space-separated)

**Returns:** `True` if this bot handles the command, `False` otherwise

#### `handle(command, args, raw_args, message, thread_context) -> Optional[str]`

Processes the command and returns a response.

```python
def handle(self, command, args, raw_args, message, thread_context):
    if command == "search":
        return f"Searching for: {' '.join(args)}"
    return None
```

**Parameters:**
- `command`: The command being executed
- `args`: Parsed arguments (List[str])
- `raw_args`: Original unparsed arguments (List[str])
- `message`: The original message object:
  - `user_id`: User who sent the command
  - `email`: User's email
  - `group_id`: Group where command was sent
  - `content`: Full message content
  - `timestamp`: ISO 8601 timestamp
  - `type`: Always "user" for commands
  - `id`: Unique message ID
  - `uuid`: Standard UUID4
- `thread_context`: List of previous messages in conversation

**Returns:** Response string to send to chat, or `None` to skip response

### Key Features

- **Automatic authentication**: BaseBot generates JWT tokens automatically
- **Automatic reconnection**: Socket.IO client reconnects on disconnect
- **Error handling**: Built-in handlers for auth errors and server errors
- **Group auto-subscription**: Bot automatically joins all groups
- **Debug logging**: Uses `self.log()` for debugging

## Bot Patterns (Command-Based vs Free-Form)

### Pattern 1: Command-Based Bots (Traditional)

Bots that handle specific commands with structured arguments.

```python
class EchoBot(BaseBot):
    BOT_COMMANDS = [
        {"name": "echo", "description": "Echo back text"},
        {"name": "ping", "description": "Check if alive"},
    ]
    
    def should_handle(self, command, args):
        return command in ["echo", "ping"]  # Selective handling
```

**Use this when:** Bot has specific, structured commands like `/echo`, `/ping`

**See implementation:** `rg "class EchoBot" bots/echo_bot.py`

### Pattern 2: Free-Form/Conversational Bots (Modern)

Bots that handle any input and respond naturally (like ChatBot).

```python
class ChatBot(LLMBot):
    BOT_COMMANDS = []  # No structured commands
    
    def should_handle(self, command, args):
        return True  # Handle everything mentioned
    
    def handle(self, command, args, raw_args, message, thread_context):
        user_message = " ".join(raw_args)  # Use raw_args, not parsed args
        # Process as free-form input, not commands
```

**Use this when:** Bot responds conversationally (like ChatBot, MediaMatchBot)

**Key differences:**
- `BOT_COMMANDS = []` (no structured commands)
- `should_handle()` returns `True` (handle everything)
- Uses `raw_args` instead of parsed `args`
- Context window parsing: `--all`, `-50` flags

**See implementation:** `rg "def should_handle" bots/chat_bot.py` and `rg "_parse_context_flags" bots/chat_bot.py`

### Pattern 3: LLM-Based Bots

Bots that use external LLM APIs (Ollama, Scaleway, OpenRouter).

Extend `LLMBot` instead of `BaseBot`:

```python
from llm_bot import LLMBot

class ChatBot(LLMBot):
    BOT_NAME = "bot"
    BOT_DESCRIPTION = "Chat with AI"
    
    def handle(self, command, args, raw_args, message, thread_context):
        prompt = " ".join(raw_args)
        return self.call_llm(prompt, system_prompt="You are helpful")
```

**Environment variables:**
- `ANSWER_LLM_PROVIDER`: `ollama` (default) or `scaleway`
- `OLLAMA_CHAT_MODEL`: Model name (default: `gpt-oss:20b`)
- `OLLAMA_HOST`: Localhost (default) or remote host
- `SCALEWAY_LLM_API_KEY`: API key for Scaleway
- `OLLAMA_MAX_TOKENS`: Max response length (default: 512)
- `OLLAMA_TEMPERATURE`: Creativity level (default: 0.3)

**See implementation:** `rg "class LLMBot" bots/llm_bot.py`, `rg "def call_llm" bots/llm_bot.py`

## Creating Your First Bot

### Step 1: Define the Bot Class

```python
#!/usr/bin/env python3
"""
Greeting Bot - Responds to greetings with personalized messages.

Usage:
    @greet hello      - Say hello back
    @greet goodbye    - Say goodbye
    @greet info       - Show bot information
"""

import sys
import pathlib

sys.path.insert(0, str(pathlib.Path(__file__).parent))

from base import BaseBot


class GreetingBot(BaseBot):
    """A simple bot that responds to greetings."""
    
    BOT_NAME = "greet"
    BOT_DESCRIPTION = "A friendly bot that responds to greetings"
    BOT_COMMANDS = [
        {"name": "hello", "description": "Say hello"},
        {"name": "goodbye", "description": "Say goodbye"},
        {"name": "info", "description": "Show bot information"},
    ]

    def should_handle(self, command, args):
        return command in ["hello", "goodbye", "info"]

    def handle(self, command, args, raw_args, message, thread_context):
        sender = self.get_sender_info(message)
        
        if command == "hello":
            name = args[0] if args else sender["display_name"]
            return f"Hello {name}! 👋"
        
        elif command == "goodbye":
            return f"Goodbye {sender['display_name']}! See you later! 👋"
        
        elif command == "info":
            return f"I'm {self.BOT_NAME}, {self.BOT_DESCRIPTION}"
        
        return None


if __name__ == "__main__":
    bot = GreetingBot()
    bot.connect()
```

### Step 2: Test Locally

1. Start the webchat server:
```bash
docker-compose up --build
```

2. In another terminal, start your bot:
```bash
python bots/greeting_bot.py
```

3. Open http://localhost:8080 and:
   - Get a JWT token
   - Join the "general" group
   - Send: `@greet hello`
   - The bot should respond: `Hello username! 👋`

### Step 3: Add to Docker Compose

Update `docker-compose.yml`:

```yaml
greeting-bot:
  build: ./bots
  command: python bots/greeting_bot.py
  environment:
    - WEBCHAT_URL=http://webchat:8080
    - WEBCHAT_JWT_SECRET=/shared_keys/jwt.key
  volumes:
    - ./shared_keys:/shared_keys:ro
  depends_on:
    - webchat
  networks:
    - mediamatch-network
```

## Available Utility Methods

BaseBot provides helper methods to simplify bot development:

### `log(message: str, level: str = "INFO")`

Log messages with bot name prefix.

```python
self.log("Processing search query")
self.log("Failed to connect to API", level="ERROR")
```

### `get_sender_info(message: dict) -> Dict[str, str]`

Extract sender information from a message.

```python
sender = self.get_sender_info(message)
print(sender["user_id"])      # "user-123"
print(sender["email"])        # "user@example.com"
print(sender["display_name"]) # "user"
```

Returns:
- `user_id`: User's system ID
- `email`: User's email address
- `display_name`: Username extracted from email (part before @)

### `format_help_response() -> str`

Generate a formatted help message for this bot.

```python
def handle(self, command, args, raw_args, message, thread_context):
    if command == "help":
        return self.format_help_response()
```

Output:
```
mybot Bot Commands:
  @mybot search - Search for something
  @mybot help - Show help message
```

### `extract_quoted_string(args: List[str]) -> Optional[str]`

Join arguments into a single string (handles phrases with spaces).

```python
def handle(self, command, args, raw_args, message, thread_context):
    if command == "echo":
        text = self.extract_quoted_string(args)
        return f"Echo: {text}"
```

### `build_context_summary(thread_context: List[dict], max_messages: int = 5) -> str`

Create a formatted summary of the thread context.

```python
def handle(self, command, args, raw_args, message, thread_context):
    summary = self.build_context_summary(thread_context, max_messages=3)
    return f"Recent messages:\n{summary}"
```

Output:
```
Thread summary (15 messages):
  user1: Hello everyone!...
  user2: Hi, how are you?...
  user1: I'm doing great...
```

## Advanced Topics

### Working with Thread Context

The `thread_context` parameter gives bots access to conversation history:

```python
def handle(self, command, args, raw_args, message, thread_context):
    if command == "summarize":
        # Access the full thread
        lines = []
        for msg in thread_context:
            sender = msg.get("user_id", "unknown")
            content = msg.get("content", "")
            timestamp = msg.get("timestamp", "")
            lines.append(f"[{timestamp}] {sender}: {content}")
        
        return "\n".join(lines)
```

**Message object structure:**
```python
{
    "id": "1711015234567-a1b2c3d4e5f6",  # Sortable ID
    "uuid": "550e8400-e29b-41d4-a716-446655440000",  # Standard UUID
    "user_id": "user-123",
    "email": "user@example.com",
    "group_id": "general",
    "content": "Hello world",
    "timestamp": "2026-03-21T12:30:45.123456",
    "type": "user" | "bot",  # Message type
    "removed": false,  # If message was deleted
    "bot_name": "echo",  # Only for bot messages
    "original_command": "@echo hello"  # Only for bot responses
}
```

### Handling Context Window Flags

Users can control how much conversation history the bot sees:

```
@mybot What happened?           # Default: last 30 messages
@mybot What happened? --all     # Full thread history
@mybot What happened? -50       # Last 50 messages
```

**Modern bots** (free-form style) should parse these flags:

```python
import re

def _parse_context_flags(self, raw_args):
    """Parse context window size from raw_args."""
    raw_string = " ".join(raw_args)
    
    # Check for --all or -all
    if re.search(r"(-{1,2}all|-{1,2}full)\b", raw_string):
        return None  # Signal for all messages
    
    # Check for -NUMBER
    match = re.search(r"-(\d+)(?:\s|$)", raw_string)
    if match:
        return int(match.group(1))
    
    return 30  # Default
```

Then use the parsed value:

```python
context_window = self._parse_context_flags(raw_args)
if context_window is None:
    filtered_context = thread_context  # Use all
else:
    filtered_context = thread_context[-context_window:]  # Use last N
```

**See implementation:** `rg "_parse_context_flags" bots/chat_bot.py`

### Async Operations

BaseBot uses synchronous Socket.IO client. For async operations:

```python
import time

def handle(self, command, args, raw_args, message, thread_context):
    if command == "fetch":
        # Long operation
        time.sleep(2)
        return "Done!"
```

**Note:** Long operations will block the bot from handling other commands. For production bots handling many concurrent users, consider using a thread pool or async library.

### Error Handling

Handle errors gracefully in your `handle()` method:

```python
def handle(self, command, args, raw_args, message, thread_context):
    try:
        if command == "search":
            query = self.extract_quoted_string(args)
            if not query:
                return "Usage: @mybot search <query>"
            
            results = self.search_api(query)
            return f"Found {len(results)} results"
    
    except Exception as e:
        self.log(f"Error handling {command}: {str(e)}", level="ERROR")
        return "Sorry, something went wrong. Please try again later."
```

### Configuration from Environment

Access environment variables in your bot:

```python
import os

class ConfigurableBot(BaseBot):
    def __init__(self):
        super().__init__()
        self.api_token = os.environ.get("MY_API_TOKEN")
        self.api_url = os.environ.get("MY_API_URL", "https://api.example.com")
```

In `docker-compose.yml`:
```yaml
my-bot:
  environment:
    - MY_API_TOKEN=secret123
    - MY_API_URL=https://api.example.com
```

## Deployment

### Local Testing

1. Run webchat: `docker-compose up --build`
2. In new terminal: `python bots/my_bot.py`
3. Open http://localhost:8080

### Docker Deployment

Add to `docker-compose.yml`:

```yaml
services:
  my-bot:
    build: ./bots
    command: python bots/my_bot.py
    environment:
      - WEBCHAT_URL=http://webchat:8080
      - WEBCHAT_JWT_SECRET=/shared_keys/jwt.key
      - MY_CUSTOM_VAR=value
    volumes:
      - ./shared_keys:/shared_keys:ro
      - ./data:/app/data  # If your bot needs persistent storage
    depends_on:
      - webchat
    networks:
      - mediamatch-network
    restart: unless-stopped
```

Deploy:
```bash
docker-compose up -d --build my-bot
```

View logs:
```bash
docker-compose logs -f my-bot
```

## Testing

### Unit Testing

Create `tests/test_my_bot.py`:

```python
import pytest
import sys
import pathlib

sys.path.insert(0, str(pathlib.Path(__file__).parent.parent / "bots"))

from my_bot import MyBot


@pytest.fixture
def bot():
    return MyBot()


def test_should_handle_hello(bot):
    assert bot.should_handle("hello", []) is True
    assert bot.should_handle("goodbye", []) is False


def test_hello_command(bot):
    message = {
        "user_id": "test-user",
        "email": "test@example.com",
        "group_id": "general"
    }
    response = bot.handle("hello", [], [], message, [])
    assert "Hello" in response


def test_hello_with_name(bot):
    message = {
        "user_id": "test-user",
        "email": "test@example.com",
        "group_id": "general"
    }
    response = bot.handle("hello", ["Alice"], [], message, [])
    assert "Alice" in response
```

Run tests:
```bash
pytest tests/test_my_bot.py -v
```

### Integration Testing

Test with a real server:

1. Start the server:
```bash
docker-compose up -d
```

2. Create test client script `test_bot_integration.py`:
```python
import socketio
import jwt
import pathlib
import time

sio = socketio.Client()
secret = pathlib.Path("/shared_keys/jwt.key").read_bytes()

@sio.on("connect")
def on_connect():
    print("Connected to server")
    token = jwt.encode({
        "sub": "test-user",
        "email": "test@example.com",
        "role": "user"
    }, secret, algorithm="HS256")
    sio.emit("authenticate", {"token": token}, namespace="/chat")

@sio.on("message", namespace="/chat")
def on_message(data):
    print(f"Received: {data['content']}")

sio.connect("http://localhost:8080", transports=["websocket"], namespace="/chat")
time.sleep(2)

# Test a bot command
sio.emit("message", {
    "group_id": "general",
    "content": "@mybot hello"
}, namespace="/chat")

time.sleep(2)
sio.disconnect()
```

Run:
```bash
python test_bot_integration.py
```

## Examples

### Example 1: Conversational Bot (Free-Form, Modern)

Bot that responds to any mention naturally, like ChatBot.

```python
import sys
import pathlib
sys.path.insert(0, str(pathlib.Path(__file__).parent))

from llm_bot import LLMBot

class SimpleBot(LLMBot):
    BOT_NAME = "mybot"
    BOT_DESCRIPTION = "Conversational AI assistant"
    BOT_COMMANDS = []  # No structured commands
    
    def should_handle(self, command, args):
        return True  # Handle everything mentioned
    
    def handle(self, command, args, raw_args, message, thread_context):
        if not raw_args:
            return ""
        
        user_message = " ".join(raw_args)
        system_prompt = "You are a helpful assistant. Respond concisely."
        
        return self.call_llm(user_message, system_prompt)

if __name__ == "__main__":
    bot = SimpleBot()
    bot.connect()
```

Usage:
```
@mybot What is Python?
→ Python is a programming language...

@mybot Explain machine learning --all
→ [Uses full thread context for response]
```

**See real implementation:** `rg "class ChatBot" bots/chat_bot.py`

### Example 2: Command-Based Bot (Traditional)

Bot with specific commands like `/ping`, `/echo`.

```python
class CalcBot(BaseBot):
    BOT_NAME = "calc"
    BOT_DESCRIPTION = "Simple calculator"
    BOT_COMMANDS = [
        {"name": "add", "description": "Add numbers: @calc add 2 3"},
        {"name": "multiply", "description": "Multiply: @calc multiply 2 3"},
    ]

    def should_handle(self, command, args):
        return command in ["add", "multiply"]

    def handle(self, command, args, raw_args, message, thread_context):
        try:
            if command == "add":
                result = sum(float(x) for x in args)
                return f"Result: {result}"
            elif command == "multiply":
                result = 1
                for x in args:
                    result *= float(x)
                return f"Result: {result}"
        except ValueError:
            return "Error: Please provide valid numbers"
        return None
```

Usage:
```
@calc add 2 3
→ Result: 5

@calc multiply 2 3 4
→ Result: 24
```

**See real implementation:** `rg "class EchoBot" bots/echo_bot.py`

### Example 3: Search/Integration Bot

Bot that integrates with external services (like MediaMatchBot).

```python
import requests
import sys
import pathlib

sys.path.insert(0, str(pathlib.Path(__file__).parent))
from base import BaseBot

class SearchBot(BaseBot):
    BOT_NAME = "search"
    BOT_DESCRIPTION = "Search external database"
    BOT_COMMANDS = []  # Free-form input
    
    def should_handle(self, command, args):
        return True
    
    def handle(self, command, args, raw_args, message, thread_context):
        query = " ".join(raw_args)
        if not query:
            return "Usage: @search <query>"
        
        try:
            # Call external API
            results = requests.get(
                "https://api.example.com/search",
                params={"q": query},
                timeout=10
            ).json()
            
            if not results:
                return "No results found"
            
            # Format results as markdown
            lines = [f"Found {len(results)} results:"]
            for item in results[:5]:
                lines.append(f"- **{item['title']}** - {item['score']:.1f}%")
            
            return "\n".join(lines)
        
        except Exception as e:
            self.log(f"Search error: {e}", level="ERROR")
            return "Search error. Try again later."
```

Usage:
```
@search machine learning models
→ Found 42 results:
  - Deep Learning Basics - 95.2%
  - Neural Networks - 89.1%
  - ...
```

**See real implementation:** `rg "class MediaMatchBot" bots/mediamatch_bot.py`, `rg "_format_results" bots/mediamatch_bot.py`

### Example 4: Context-Aware Bot

Bot that analyzes thread history.

```python
class ContextBot(BaseBot):
    BOT_NAME = "context"
    BOT_DESCRIPTION = "Analyze conversation"
    BOT_COMMANDS = [
        {"name": "count", "description": "Count messages"},
        {"name": "analyze", "description": "Analyze thread"},
    ]

    def should_handle(self, command, args):
        return command in ["analyze", "count"]

    def handle(self, command, args, raw_args, message, thread_context):
        if command == "count":
            return f"Thread has {len(thread_context)} messages"
        
        elif command == "analyze":
            users = set()
            bot_count = 0
            for msg in thread_context:
                users.add(msg.get("user_id", "unknown"))
                if msg.get("type") == "bot":
                    bot_count += 1
            
            return (
                f"**Thread Analysis:**\n"
                f"- Total messages: {len(thread_context)}\n"
                f"- Unique users: {len(users)}\n"
                f"- Bot responses: {bot_count}"
            )
        
        return None
```

## Troubleshooting

### Bot Won't Connect

**Problem:** Bot fails to connect to webchat server

**Solutions:**
1. Check server is running: `docker-compose ps`
2. Verify WEBCHAT_URL: Should be `http://webchat:8080` in Docker, `http://localhost:8080` locally
3. Check JWT secret is accessible: `ls -la /shared_keys/jwt.key`
4. Look at bot logs: `docker-compose logs my-bot`

### Bot Receives No Commands

**Problem:** Bot connects but doesn't receive any commands

**Solutions:**
1. Verify bot registered successfully - look for "authenticated" message in logs
2. Check `BOT_NAME` matches what users type: `@mybot` not `@my_bot`
3. Ensure `should_handle()` returns `True` for your command
4. Test with echo bot first: `@echo ping`

### Commands Work But Response is Ignored

**Problem:** Command is received but bot response doesn't appear

**Solutions:**
1. Check `handle()` returns a string (not None)
2. Verify response is not empty: `return ""` won't show
3. Check group_id matches: Response must go to same group as command
4. Look at server logs: `docker-compose logs webchat`

### TypeError: 'NoneType' object is not iterable

**Problem:** When accessing `thread_context`

**Solutions:**
1. Always check if `thread_context` is not None:
```python
if thread_context:
    for msg in thread_context:
        ...
```

2. Check message dictionary keys exist:
```python
content = msg.get("content", "")  # Use get() with defaults
```

### JWT Token Errors

**Problem:** "Token expired" or "Invalid token"

**Solutions:**
1. Token TTL is 1 hour - tokens expire
2. JWT secret must match between server and bot: 
   - Both should read from `/shared_keys/jwt.key`
3. System clock must be accurate (JWT uses timestamps)

### Memory Leaks / High CPU

**Problem:** Bot process grows in memory or uses 100% CPU

**Solutions:**
1. Avoid infinite loops in `handle()` method
2. Don't create threads without managing them
3. Close external connections (databases, APIs) properly
4. Use timeouts on external requests:
```python
response = requests.get(url, timeout=5)
```

## Quick Reference: Bot Types

| Type | BOT_COMMANDS | should_handle | Best For | Example |
|------|--------------|---------------|----------|---------|
| **Command-Based** | Filled | Selective | Structured commands | `@calc add 2 3` |
| **Free-Form** | Empty `[]` | `return True` | Conversational | `@bot What is AI?` |
| **LLM-Based** | Empty `[]` | `return True` | AI responses | `ChatBot(LLMBot)` |
| **Search** | Empty `[]` | `return True` | External APIs | `@mediamatch video` |

## Finding Implementation Details

**Quick lookups with `rg`:**

```bash
# Find all bot implementations
rg "^class.*BaseBot" bots/

# Find free-form bots (BOT_COMMANDS = [])
rg "BOT_COMMANDS = \[\]" bots/

# Find LLM bots
rg "class.*LLMBot" bots/

# See context window parsing
rg "_parse_context_flags" bots/

# See LLM calling
rg "def call_llm" bots/llm_bot.py

# See message formatting
rg "_format_results" bots/mediamatch_bot.py
```

---

**Need help?** 
- Check existing bots: `rg "class.*Bot" bots/`
- Review BaseBot API: `rg "def " bots/base.py`
- See latest patterns: `cat bots/chat_bot.py` or `cat bots/mediamatch_bot.py`
