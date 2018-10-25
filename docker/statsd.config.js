config = {
    // debug:  true,
    dumpMessages:  true,
    // 'graphiteHost': '127.0.0.1',
    // 'graphitePort': 2003,
    'port': 8125,
    'flushInterval': 1,
    'servers': [
        {server: './servers/udp', address: '0.0.0.0', port: 8125}
    ]
}
