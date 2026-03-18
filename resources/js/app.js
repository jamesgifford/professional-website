import { initCircleBackground } from './circle-background.js';
import hljs from 'highlight.js/lib/core';

import bash from 'highlight.js/lib/languages/bash';
import css from 'highlight.js/lib/languages/css';
import html from 'highlight.js/lib/languages/xml';
import javascript from 'highlight.js/lib/languages/javascript';
import json from 'highlight.js/lib/languages/json';
import php from 'highlight.js/lib/languages/php';
import sql from 'highlight.js/lib/languages/sql';
import typescript from 'highlight.js/lib/languages/typescript';

hljs.registerLanguage('bash', bash);
hljs.registerLanguage('css', css);
hljs.registerLanguage('html', html);
hljs.registerLanguage('javascript', javascript);
hljs.registerLanguage('json', json);
hljs.registerLanguage('php', php);
hljs.registerLanguage('sql', sql);
hljs.registerLanguage('typescript', typescript);

document.addEventListener('DOMContentLoaded', () => {
    hljs.highlightAll();
});

initCircleBackground();
