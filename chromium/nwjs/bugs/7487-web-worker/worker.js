self.onmessage = e => console.log('worker', e.data);
self.postMessage('OK');