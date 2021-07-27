import Vue from './../node_modules/vue/dist/vue.esm.js';

const root = new Vue({
    el: '#app',
    template: `
    <div class="homepage">
        <div class="hello">
            <h1>Hello world!</h1>
            
<pre><code>npm install
npm run dev
</code></pre>
        </div>
    </div>
    `
});
