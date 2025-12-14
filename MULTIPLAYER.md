# GeoPinner Multiplayer Guide

## Overview

GeoPinner supports real-time multiplayer gameplay using **Laravel Reverb**, Laravel's official WebSocket server for broadcasting.

## How It Works

- **Broadcasting**: Real-time communication using Laravel Reverb WebSocket server
- **Events**: Player actions (joining, guessing, etc.) are broadcast to all players in a game
- **Game Channels**: Each game has its own channel (`game.{code}`) for isolated communication

## Starting the Reverb Server

### Option 1: Using Laravel Herd (Recommended)

Laravel Herd automatically manages Reverb for you. Simply start Reverb using:

```bash
php artisan reverb:start
```

This will start the Reverb server at `reverb.herd.test` (port 443 with HTTPS).

### Option 2: Manual Start

If not using Herd, start Reverb with:

```bash
php artisan reverb:start --host=0.0.0.0 --port=8080
```

Then update your `.env` file:
```env
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

## Playing Multiplayer

1. **Start Reverb Server**:
   ```bash
   php artisan reverb:start
   ```

2. **Create a Game**:
   - Navigate to the multiplayer page
   - Enter your name as host
   - Select game settings (difficulty, rounds, etc.)
   - Click "Create Game"
   - Share the generated game code with friends

3. **Join a Game**:
   - Enter your name
   - Enter the game code shared by the host
   - Click "Join Game"
   - Wait for the host to start the game

4. **Play**:
   - Host clicks "Start Game" when all players are ready
   - All players see the same location question
   - Click on the map to guess the location
   - Results are shown when all players have guessed or time runs out
   - Game automatically moves to the next round

## Broadcasting Events

The multiplayer system broadcasts these events:

- `PlayerJoined` - When a player joins the game
- `GameStarted` - When the host starts the game
- `RoundStarted` - When a new round begins
- `GuessSubmitted` - When a player submits their guess
- `RoundCompleted` - When all players have guessed
- `GameCompleted` - When all rounds are finished

## Troubleshooting

### Reverb Not Starting

- Check if port 443 is already in use
- Ensure your `.env` has correct Reverb configuration:
  ```env
  BROADCAST_CONNECTION=reverb
  REVERB_APP_ID=1001
  REVERB_APP_KEY=laravel-herd
  REVERB_APP_SECRET=secret
  REVERB_HOST="reverb.herd.test"
  REVERB_PORT=443
  REVERB_SCHEME=https
  ```

### Players Not Seeing Updates

- Verify Reverb server is running
- Check browser console for WebSocket connection errors
- Ensure `VITE_REVERB_*` variables match `REVERB_*` variables in `.env`

### Connection Refused

- If using Herd, ensure Reverb is configured for `reverb.herd.test`
- Check firewall settings aren't blocking the connection
- Verify SSL certificates are valid (Herd handles this automatically)

## Development Tips

- **Keep Reverb Running**: Run Reverb in a separate terminal tab while developing
- **Monitor Connections**: Watch the Reverb output to see connections and disconnections
- **Clear Browser Cache**: If experiencing issues, clear browser cache and reload

## Configuration

Key configuration files:

- `config/reverb.php` - Reverb server configuration
- `config/broadcasting.php` - Broadcasting driver configuration
- `routes/channels.php` - Channel authorization
- `app/Events/*` - Broadcasting events

## Production Deployment

For production, consider:

1. Running Reverb as a system service (systemd, supervisor)
2. Using a process manager to restart on failure
3. Configuring SSL/TLS certificates
4. Setting up proper monitoring and logging

## Need Help?

- Check Laravel Reverb docs: https://laravel.com/docs/12.x/reverb
- Review the events in `app/Events/`
- Check the Multiplayer Livewire component: `app/Livewire/Multiplayer.php`
