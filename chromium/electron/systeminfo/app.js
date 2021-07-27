const si = require('systeminformation');
const Vue = require('vue/dist/vue');

function init() {
    const systeminformation = Vue.extend({
        data: () => ({
            memory: null,
            network: null,
            cpu: null,
            cpuSpeed: null,
        }),
        template: `
        <div>
            <div v-if="memory">
                <h2>Memory</h2>
                <div>
                    {{ memory.active }} | {{ memory.total }}
                </div>
            </div>
            <div v-if="cpu && cpuSpeed">
                <h2>CPU</h2>
                <div>
                    {{ cpu.cores}} x {{ cpu.speed }} Ghz
                </div>
            </div>
            <div v-if="network">
                <h2>Network</h2>
                <div>
                    RX: {{ network.rx_sec }} / TX: {{ network.tx_sec }}
                </div>
            </div>
        </div>`,
        mounted() {
            const monitor = this;
            setInterval(function () {
                si.networkStats().then(data => {
                    monitor.network = data;
                });

                si.mem().then(data => {
                    monitor.memory = data;
                    monitor.memory.lowMemory = data.available < 2 * Math.pow(1024, 3);
                });

                si.cpu().then(data => {
                    monitor.cpu = data;
                });

                si.cpuCurrentspeed().then(data => {
                    monitor.cpuSpeed = data;
                });
            }, 1000);
        }
    });

    new Vue({
        components: {
            si: systeminformation
        },
        template: `
        <div>
            <h1>System information</h1>
            <si/>
        </div>
        `
    }).$mount('#app');
}

document.addEventListener("DOMContentLoaded", init);

