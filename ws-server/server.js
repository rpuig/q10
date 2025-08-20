const WebSocket = require('ws');
const Redis = require('redis');

const WS_PORT = process.env.WS_PORT || 8082;
const REDIS_HOST = process.env.REDIS_HOST || 'redis';
const REDIS_PORT = process.env.REDIS_PORT || 6379;

console.log(`Starting WS server on port ${WS_PORT}, redis ${REDIS_HOST}:${REDIS_PORT}`);

// Create redis client and subscriber
const redisClient = Redis.createClient({ url: `redis://${REDIS_HOST}:${REDIS_PORT}` });
const redisSub = Redis.createClient({ url: `redis://${REDIS_HOST}:${REDIS_PORT}` });
redisClient.on('error', (err) => console.error('redisClient error', err));
redisSub.on('error', (err) => console.error('redisSub error', err));

(async () => {
  await redisClient.connect();
  await redisSub.connect();

  const wss = new WebSocket.Server({ port: WS_PORT });

  // Map to track which channels each client is subscribed to
  const clientChannels = new Map();

  wss.on('connection', function connection(ws, req) {
    const id = Math.random().toString(36).slice(2, 9);
    console.log(`[ws] client connected id=${id} remote=${req.socket.remoteAddress}`);
    clientChannels.set(ws, new Set());

    ws.on('message', function message(msg) {
      console.log(`[ws] recv from ${id}: ${msg}`);
      // The client may send a subscription command like: {"subscribe":"chat:channel:1:2"}
      try {
        const data = JSON.parse(msg.toString());
        if (data.subscribe) {
          const channel = data.subscribe;
          clientChannels.get(ws).add(channel);
          console.log(`[ws] ${id} subscribe ${channel}`);
        }
        if (data.unsubscribe) {
          const channel = data.unsubscribe;
          clientChannels.get(ws).delete(channel);
          console.log(`[ws] ${id} unsubscribe ${channel}`);
        }
      } catch (e) {
        console.log('[ws] non-json message');
      }
    });

    ws.on('close', function(code, reason) {
      console.log(`[ws] client closed id=${id} code=${code} reason=${reason}`);
      clientChannels.delete(ws);
    });

    ws.on('error', function(err) {
      console.error('[ws] client error', err);
    });
  });

  // Subscribe to wildcard-ish pattern is not supported; we'll subscribe to channels dynamically when needed
  // For now subscribe to a common prefix for debugging
  const debugChannel = 'chat:channel:DEBUG';
  await redisSub.subscribe(debugChannel, (message) => {
    console.log(`[redis_sub] recv ${debugChannel} => ${message}`);
    // Broadcast to all clients
    wss.clients.forEach((client) => {
      if (client.readyState === WebSocket.OPEN) {
        client.send(message);
      }
    });
  });

  // Additionally, handle messages on the general channel pattern by subscribing to all channels listed in a Redis set
  // (Left as future improvement)

  console.log('WS server ready');
})();
