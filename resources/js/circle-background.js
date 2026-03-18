const KEYWORDS = [
    'const', 'return', 'class', 'yield', 'match', 'enum', 'trait', 'use',
    'new', 'null', 'true', 'false', 'void', 'function', 'public', 'private',
    'protected', 'static', 'abstract', 'interface', 'extends', 'implements',
    'namespace', 'echo', 'array', 'isset', 'unset', 'foreach', 'while',
    'throw', 'catch', 'try', 'finally', 'readonly', 'fn',
];

const SYMBOLS = [
    '<?php', '?>', '=>', '::', '&&', '||', '...', '->', '===', '!==',
    '??', '/**', '*/', '$this', '<?', '<=>', '->>', '|', '&', '??=',
    '++', '--', '**', '%', '.=', '[]', '!=', '==', '>=', '<=', '>>',
    '<<', '+=', '-=', '*=', '/=', '%=', '**=', '&=', '|=', '^=',
    '<<=', '>>=', '.', '~', '^', '@', '!', '()', '{}', ';', '->',
    '??->', '#[', ']', '...', '::', '&&', '||',
];

const TOKEN_POOL = [...KEYWORDS, ...SYMBOLS];

const PHP_CODE_BLOCKS = [
    'namespace App\\Http\\Controllers; use Illuminate\\Http\\JsonResponse; use App\\Models\\User; class UserController extends Controller { public function index(): JsonResponse { $users = User::query()->with(["roles", "permissions"])->where("active", true)->orderBy("created_at", "desc")->paginate(25); return response()->json(["data" => $users, "status" => "success"]); } public function show(int $id): JsonResponse { $user = User::findOrFail($id); $this->authorize("view", $user); return response()->json($user->loadMissing("profile")); } public function store(StoreUserRequest $request): JsonResponse { $validated = $request->validated(); $user = User::create($validated); event(new UserCreated($user)); return response()->json($user, 201); } }',
    'namespace App\\Services; use App\\Models\\Order; use Illuminate\\Support\\Facades\\DB; class OrderService { private float $taxRate = 0.08; public function calculateTotal(array $items): float { return array_reduce($items, fn($carry, $item) => $carry + ($item["price"] * $item["qty"]), 0); } public function process(array $items): Order { return DB::transaction(function () use ($items) { $order = Order::create(["status" => "pending", "total" => 0]); $total = 0; foreach ($items as $item) { $line = $order->lines()->create($item); $total += $line->price * $line->quantity; } $order->update(["total" => round($total * (1 + $this->taxRate), 2), "status" => "confirmed"]); return $order; }); } }',
    'namespace App\\Http\\Middleware; use Closure; use Illuminate\\Http\\Request; use Symfony\\Component\\HttpFoundation\\Response; class RateLimiter { private int $maxAttempts = 60; public function handle(Request $request, Closure $next): Response { $key = "rate:" . $request->fingerprint(); $attempts = (int) cache()->get($key, 0); if ($attempts >= $this->maxAttempts) { abort(429, "Too Many Requests"); } cache()->put($key, $attempts + 1, now()->addMinute()); $response = $next($request); $response->headers->set("X-RateLimit-Remaining", $this->maxAttempts - $attempts - 1); return $response; } }',
    'namespace App\\Models; use Illuminate\\Database\\Eloquent\\Model; use Illuminate\\Database\\Eloquent\\Relations\\HasMany; use Illuminate\\Database\\Eloquent\\Relations\\BelongsTo; class Project extends Model { protected $fillable = ["name", "description", "status", "deadline", "budget"]; protected function casts(): array { return ["deadline" => "datetime", "metadata" => "array", "budget" => "decimal:2"]; } public function tasks(): HasMany { return $this->hasMany(Task::class)->orderBy("priority", "desc"); } public function owner(): BelongsTo { return $this->belongsTo(User::class, "owner_id"); } public function scopeActive($query) { return $query->where("status", "!=", "archived")->where("deadline", ">", now()); } }',
];

function shuffle(arr) {
    const a = [...arr];
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
}

function randomRange(min, max) {
    return min + Math.random() * (max - min);
}

function isDark() {
    return document.documentElement.classList.contains('dark');
}

function createOrbits(w, h) {
    const count = 4;
    const minGap = 120;
    const orbits = [];

    // All orbits share a single center point off-screen to the left
    const cx = randomRange(-400, -150);
    const cy = randomRange(h * 0.25, h * 0.75);

    // Radii increase outward from the shared center, with spacing
    // The innermost orbit should just reach into the viewport,
    // the outermost should sweep well across it.
    const rMin = Math.abs(cx) + randomRange(50, 150);
    const rMax = rMin + w * randomRange(0.8, 1.2);
    const band = (rMax - rMin) / count;

    const baseRadii = [];
    for (let i = 0; i < count; i++) {
        const lo = rMin + band * i + minGap * 0.3;
        const hi = rMin + band * (i + 1) - minGap * 0.3;
        baseRadii.push(randomRange(lo, hi));
    }

    // Enforce minimum gap so orbits (with their interior/exterior decorations) never overlap
    for (let i = 1; i < count; i++) {
        if (baseRadii[i] - baseRadii[i - 1] < minGap) {
            baseRadii[i] = baseRadii[i - 1] + minGap;
        }
    }

    for (let i = 0; i < count; i++) {
        const radius = baseRadii[i];

        // Scale token count to radius so arc-distance between tokens stays consistent
        const desiredSpacing = 120; // px between tokens along the arc
        const circumference = 2 * Math.PI * radius;
        const tokenCount = Math.max(8, Math.round(circumference / desiredSpacing));
        const pool = shuffle(TOKEN_POOL);
        const tokens = [];

        for (let j = 0; j < tokenCount; j++) {
            tokens.push({
                text: pool[j % pool.length],
                angle: (Math.PI * 2 * j) / tokenCount,
            });
        }

        // Pre-generate line numbers with random increments
        const lineNumbers = [];
        let lineNum = Math.floor(randomRange(1, 20));
        for (let j = 0; j < tokenCount; j++) {
            lineNumbers.push(lineNum);
            lineNum += Math.floor(randomRange(1, 8));
        }

        // Pre-generate memory address annotations (halfway between tokens)
        const addresses = [];
        for (let j = 0; j < tokenCount; j++) {
            addresses.push('0x' + Math.floor(Math.random() * 0xFFFF).toString(16).toUpperCase().padStart(4, '0'));
        }

        // Alternate clockwise and counterclockwise
        const direction = i % 2 === 0 ? 1 : -1;

        // Build code text long enough to fill the circumference
        const baseCode = PHP_CODE_BLOCKS[i % PHP_CODE_BLOCKS.length];
        const codeText = baseCode + '    ' + baseCode;

        orbits.push({
            cx,
            cy,
            radius,
            rotation: Math.random() * Math.PI * 2,
            counterRotation: Math.random() * Math.PI * 2,
            rotationSpeed: randomRange(0.003, 0.008) * direction,
            tokens,
            lineNumbers,
            addresses,
            codeText,
            fontSize: Math.floor(randomRange(11, 14)),
        });
    }

    return orbits;
}

// Interior layout offsets from orbit radius (toward center)
const DASHED_LINE_OFFSET = 28;
const DOTTED_LINE_OFFSET = 38;
const CODE_RADIUS_OFFSET = DASHED_LINE_OFFSET / 2; // centered between orbit line and dashed line
const CODE_FONT_SIZE = 9;
const ANNOTATION_FONT_SIZE = 8;

// Typing effect states
const TE_IDLE = 0;
const TE_HIGHLIGHT = 1;
const TE_DELETING = 2;
const TE_PAUSE = 3;
const TE_TYPING = 4;
const TE_HOLD = 5;
const TE_FADE = 6;

// Breakpoint effect states
const BP_IDLE = 0;
const BP_APPEAR = 1;
const BP_PULSE = 2;
const BP_FADE = 3;

// Typo correction effect states
const TC_IDLE = 0;
const TC_SCAN = 1;
const TC_INTRODUCE = 2;
const TC_HOLD_TYPO = 3;
const TC_CORRECT = 4;
const TC_HOLD_CORRECT = 5;
const TC_FADE = 6;

// Keyboard neighbor map for typo generation
const KEYBOARD_NEIGHBORS = {
    a: 'sq', b: 'vn', c: 'xv', d: 'sf', e: 'rw', f: 'dg', g: 'fh',
    h: 'gj', i: 'ou', j: 'hk', k: 'jl', l: 'k', m: 'n', n: 'bm',
    o: 'ip', p: 'o', q: 'wa', r: 'et', s: 'ad', t: 'ry', u: 'yi',
    v: 'cb', w: 'qe', x: 'zc', y: 'tu', z: 'x',
};

export function initCircleBackground() {
    const canvas = document.createElement('canvas');
    canvas.style.cssText = 'position:fixed;inset:0;z-index:-10;pointer-events:none;';
    document.body.prepend(canvas);

    const ctx = canvas.getContext('2d');
    let w, h, dpr;
    let orbits = [];
    let charWidthCache = {};
    let fontsReady = false;

    // Token offset distance from orbit line
    const TOKEN_OFFSET = 14;

    // Breakpoint effect state
    const breakpointEffect = {
        state: BP_IDLE,
        timer: randomRange(20, 35),
        orbitIndex: -1,
        tokenIndex: -1,
        opacity: 0,
        pulseTime: 0,
    };

    // Typing effect state
    const typingEffect = {
        state: TE_IDLE,
        timer: randomRange(15, 25),
        orbitIndex: -1,
        tokenIndex: -1,
        oldText: '',
        newText: '',
        charProgress: 0,
        charTimer: 0,
        cursorTimer: 0,
        cursorVisible: true,
        fadeProgress: 0,
    };

    // Typo correction effect state
    const typoEffect = {
        state: TC_IDLE,
        timer: randomRange(25, 40),
        word: '',
        typo: '',
        occurrences: [],       // [{orbitIndex, startIndex}]
        highlightSets: [],     // Set<number> per orbit
        primaryIndex: -1,      // index into occurrences for the animated one
        primaryOverride: null,  // string override during introduce/correct
        highlightOpacity: 0,
        subPhase: 'delete',    // 'delete' or 'type' within TC_INTRODUCE / TC_CORRECT
        charProgress: 0,
        charTimer: 0,
    };

    function generateTypo(word) {
        const lower = word.toLowerCase();
        // 50/50: swap adjacent chars or replace with keyboard neighbor
        if (Math.random() < 0.5 && word.length >= 2) {
            // Swap two adjacent characters (not first char to keep it recognizable)
            const pos = 1 + Math.floor(Math.random() * (word.length - 2));
            const arr = word.split('');
            [arr[pos], arr[pos + 1]] = [arr[pos + 1], arr[pos]];
            const result = arr.join('');
            if (result !== word) return result;
        }
        // Replace one char with keyboard neighbor
        for (let attempt = 0; attempt < 10; attempt++) {
            const pos = Math.floor(Math.random() * word.length);
            const ch = lower[pos];
            const neighbors = KEYBOARD_NEIGHBORS[ch];
            if (neighbors && neighbors.length > 0) {
                const replacement = neighbors[Math.floor(Math.random() * neighbors.length)];
                const arr = word.split('');
                // Preserve original case
                arr[pos] = word[pos] === word[pos].toUpperCase() ? replacement.toUpperCase() : replacement;
                return arr.join('');
            }
        }
        // Fallback: swap first two swappable chars
        if (word.length >= 2) {
            const arr = word.split('');
            [arr[0], arr[1]] = [arr[1], arr[0]];
            return arr.join('');
        }
        return word;
    }

    function findAllOccurrences(word) {
        const results = [];
        for (let oi = 0; oi < orbits.length; oi++) {
            const text = orbits[oi].codeText;
            let pos = 0;
            while (true) {
                const idx = text.indexOf(word, pos);
                if (idx === -1) break;
                if (idx + word.length <= text.length) {
                    results.push({ orbitIndex: oi, startIndex: idx });
                }
                pos = idx + 1;
            }
        }
        return results;
    }

    function buildHighlightSets(occurrences, wordLength) {
        const sets = orbits.map(() => new Set());
        for (const occ of occurrences) {
            for (let i = 0; i < wordLength; i++) {
                sets[occ.orbitIndex].add(occ.startIndex + i);
            }
        }
        return sets;
    }

    function pickTypoTarget() {
        // Scan all orbits for words >= 5 chars
        const wordCounts = {};
        for (let oi = 0; oi < orbits.length; oi++) {
            const text = orbits[oi].codeText;
            const matches = text.matchAll(/[a-zA-Z]{5,}/g);
            for (const m of matches) {
                const w = m[0];
                if (!wordCounts[w]) wordCounts[w] = new Set();
                wordCounts[w].add(oi);
            }
        }

        // Filter to words appearing in >= 2 orbits
        const candidates = Object.entries(wordCounts)
            .filter(([, orbitSet]) => orbitSet.size >= 2)
            .map(([w]) => w);

        if (candidates.length === 0) return false;

        const chosen = candidates[Math.floor(Math.random() * candidates.length)];
        const occurrences = findAllOccurrences(chosen);
        if (occurrences.length < 2) return false;

        // Pick primary instance — prefer one currently in viewport
        let primaryIdx = 0;
        for (let i = 0; i < occurrences.length; i++) {
            const occ = occurrences[i];
            const orbit = orbits[occ.orbitIndex];
            const codeRadius = orbit.radius - CODE_RADIUS_OFFSET;
            // Approximate position of word start
            let angle = orbit.counterRotation;
            for (let c = 0; c < occ.startIndex; c++) {
                const ch = orbit.codeText[c];
                angle += getCharWidth(ch, CODE_FONT_SIZE) / codeRadius;
            }
            const x = orbit.cx + Math.cos(angle) * codeRadius;
            const y = orbit.cy + Math.sin(angle) * codeRadius;
            if (x > 0 && x < w && y > 0 && y < h) {
                primaryIdx = i;
                break;
            }
        }

        const typo = generateTypo(chosen);
        if (typo === chosen) return false;

        typoEffect.word = chosen;
        typoEffect.typo = typo;
        typoEffect.occurrences = occurrences;
        typoEffect.highlightSets = buildHighlightSets(occurrences, chosen.length);
        typoEffect.primaryIndex = primaryIdx;
        typoEffect.primaryOverride = null;
        typoEffect.highlightOpacity = 0;
        typoEffect.charProgress = 0;
        typoEffect.charTimer = 0;
        return true;
    }

    function updateTypoEffect(dt) {
        switch (typoEffect.state) {
            case TC_IDLE:
                typoEffect.timer -= dt;
                // Stagger: don't start if typing effect is active
                if (typoEffect.timer <= 0) {
                    if (typingEffect.state !== TE_IDLE) {
                        typoEffect.timer = randomRange(3, 5);
                        break;
                    }
                    if (pickTypoTarget()) {
                        typoEffect.state = TC_SCAN;
                        typoEffect.timer = 0.6;
                        typoEffect.highlightOpacity = 0;
                    } else {
                        typoEffect.timer = randomRange(5, 10);
                    }
                }
                break;

            case TC_SCAN:
                typoEffect.timer -= dt;
                typoEffect.highlightOpacity = Math.min(1, 1 - (typoEffect.timer / 0.6));
                if (typoEffect.timer <= 0) {
                    typoEffect.highlightOpacity = 1;
                    typoEffect.state = TC_INTRODUCE;
                    typoEffect.subPhase = 'delete';
                    typoEffect.charProgress = typoEffect.word.length;
                    typoEffect.charTimer = 0;
                    typoEffect.primaryOverride = typoEffect.word;
                }
                break;

            case TC_INTRODUCE:
                typoEffect.charTimer += dt;
                if (typoEffect.subPhase === 'delete') {
                    if (typoEffect.charTimer >= 0.15) {
                        typoEffect.charTimer -= 0.15;
                        typoEffect.charProgress--;
                        typoEffect.primaryOverride = typoEffect.word.slice(0, typoEffect.charProgress);
                        if (typoEffect.charProgress <= 0) {
                            typoEffect.subPhase = 'type';
                            typoEffect.charProgress = 0;
                            typoEffect.charTimer = 0;
                            typoEffect.primaryOverride = '';
                        }
                    }
                } else {
                    if (typoEffect.charTimer >= 0.15) {
                        typoEffect.charTimer -= 0.15;
                        typoEffect.charProgress++;
                        typoEffect.primaryOverride = typoEffect.typo.slice(0, typoEffect.charProgress);
                        if (typoEffect.charProgress >= typoEffect.typo.length) {
                            typoEffect.primaryOverride = typoEffect.typo;
                            typoEffect.state = TC_HOLD_TYPO;
                            typoEffect.timer = 1.0;
                        }
                    }
                }
                break;

            case TC_HOLD_TYPO:
                typoEffect.timer -= dt;
                if (typoEffect.timer <= 0) {
                    typoEffect.state = TC_CORRECT;
                    typoEffect.subPhase = 'delete';
                    typoEffect.charProgress = typoEffect.typo.length;
                    typoEffect.charTimer = 0;
                    typoEffect.primaryOverride = typoEffect.typo;
                }
                break;

            case TC_CORRECT:
                typoEffect.charTimer += dt;
                if (typoEffect.subPhase === 'delete') {
                    if (typoEffect.charTimer >= 0.12) {
                        typoEffect.charTimer -= 0.12;
                        typoEffect.charProgress--;
                        typoEffect.primaryOverride = typoEffect.typo.slice(0, typoEffect.charProgress);
                        if (typoEffect.charProgress <= 0) {
                            typoEffect.subPhase = 'type';
                            typoEffect.charProgress = 0;
                            typoEffect.charTimer = 0;
                            typoEffect.primaryOverride = '';
                        }
                    }
                } else {
                    if (typoEffect.charTimer >= 0.12) {
                        typoEffect.charTimer -= 0.12;
                        typoEffect.charProgress++;
                        typoEffect.primaryOverride = typoEffect.word.slice(0, typoEffect.charProgress);
                        if (typoEffect.charProgress >= typoEffect.word.length) {
                            typoEffect.primaryOverride = null;
                            typoEffect.state = TC_HOLD_CORRECT;
                            typoEffect.timer = 0.8;
                        }
                    }
                }
                break;

            case TC_HOLD_CORRECT:
                typoEffect.timer -= dt;
                if (typoEffect.timer <= 0) {
                    typoEffect.state = TC_FADE;
                    typoEffect.timer = 0.6;
                }
                break;

            case TC_FADE:
                typoEffect.timer -= dt;
                typoEffect.highlightOpacity = Math.max(0, typoEffect.timer / 0.6);
                if (typoEffect.timer <= 0) {
                    typoEffect.highlightOpacity = 0;
                    typoEffect.state = TC_IDLE;
                    typoEffect.timer = randomRange(25, 40);
                    typoEffect.occurrences = [];
                    typoEffect.highlightSets = [];
                    typoEffect.primaryIndex = -1;
                    typoEffect.primaryOverride = null;
                }
                break;
        }
    }

    function resize() {
        dpr = window.devicePixelRatio || 1;
        w = window.innerWidth;
        h = window.innerHeight;
        canvas.width = w * dpr;
        canvas.height = h * dpr;
        canvas.style.width = w + 'px';
        canvas.style.height = h + 'px';
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function initOrbits() {
        orbits = createOrbits(w, h);
    }

    function measureCharWidths() {
        charWidthCache = {};
        ctx.font = '12px "JetBrains Mono", monospace';
        // Measure all printable ASCII to cover tokens, code, and annotations
        for (let i = 32; i < 127; i++) {
            const ch = String.fromCharCode(i);
            charWidthCache[ch] = ctx.measureText(ch).width;
        }
    }

    function getCharWidth(ch, fontSize) {
        const base = charWidthCache[ch] || 7;
        return base * (fontSize / 12);
    }

    function getTokenWidth(text, fontSize) {
        let total = 0;
        for (const ch of text) {
            total += getCharWidth(ch, fontSize);
        }
        return total;
    }

    function pickTypingTarget() {
        const candidates = [];
        const marginX = w * 0.2;
        const marginY = h * 0.2;

        for (let oi = 0; oi < orbits.length; oi++) {
            const o = orbits[oi];
            for (let ti = 0; ti < o.tokens.length; ti++) {
                const token = o.tokens[ti];
                const angle = o.rotation + token.angle;
                const tx = o.cx + Math.cos(angle) * o.radius;
                const ty = o.cy + Math.sin(angle) * o.radius;

                if (tx > marginX && tx < w - marginX && ty > marginY && ty < h - marginY) {
                    const isKeyword = KEYWORDS.includes(token.text);
                    candidates.push({ oi, ti, isKeyword });
                }
            }
        }

        if (candidates.length === 0) return false;

        // Prefer keywords
        const keywords = candidates.filter(c => c.isKeyword);
        const pool = keywords.length > 0 ? keywords : candidates;
        const chosen = pool[Math.floor(Math.random() * pool.length)];

        const currentText = orbits[chosen.oi].tokens[chosen.ti].text;
        let newText;
        do {
            newText = TOKEN_POOL[Math.floor(Math.random() * TOKEN_POOL.length)];
        } while (newText === currentText);

        typingEffect.orbitIndex = chosen.oi;
        typingEffect.tokenIndex = chosen.ti;
        typingEffect.oldText = currentText;
        typingEffect.newText = newText;
        typingEffect.charProgress = 0;
        typingEffect.charTimer = 0;
        typingEffect.cursorTimer = 0;
        typingEffect.cursorVisible = true;
        typingEffect.fadeProgress = 0;
        return true;
    }

    function pickBreakpointTarget() {
        const candidates = [];
        const marginX = w * 0.2;
        const marginY = h * 0.2;

        for (let oi = 0; oi < orbits.length; oi++) {
            const o = orbits[oi];
            for (let ti = 0; ti < o.tokens.length; ti++) {
                const token = o.tokens[ti];
                const angle = o.rotation + token.angle;
                const tx = o.cx + Math.cos(angle) * o.radius;
                const ty = o.cy + Math.sin(angle) * o.radius;

                if (tx > marginX && tx < w - marginX && ty > marginY && ty < h - marginY) {
                    // Prefer a different orbit than the typing effect target
                    if (typingEffect.state !== TE_IDLE && typingEffect.orbitIndex === oi && typingEffect.tokenIndex === ti) {
                        continue;
                    }
                    candidates.push({ oi, ti });
                }
            }
        }

        if (candidates.length === 0) return false;

        // Prefer a different orbit than the active typing effect
        const diffOrbit = candidates.filter(c => c.oi !== typingEffect.orbitIndex);
        const pool = diffOrbit.length > 0 ? diffOrbit : candidates;
        const chosen = pool[Math.floor(Math.random() * pool.length)];

        breakpointEffect.orbitIndex = chosen.oi;
        breakpointEffect.tokenIndex = chosen.ti;
        breakpointEffect.opacity = 0;
        breakpointEffect.pulseTime = 0;
        return true;
    }

    function updateBreakpointEffect(dt) {
        switch (breakpointEffect.state) {
            case BP_IDLE:
                breakpointEffect.timer -= dt;
                if (breakpointEffect.timer <= 0) {
                    if (pickBreakpointTarget()) {
                        breakpointEffect.state = BP_APPEAR;
                        breakpointEffect.timer = 0.3;
                    } else {
                        breakpointEffect.timer = 2;
                    }
                }
                break;

            case BP_APPEAR:
                breakpointEffect.timer -= dt;
                breakpointEffect.opacity = 1 - (breakpointEffect.timer / 0.3);
                if (breakpointEffect.timer <= 0) {
                    breakpointEffect.opacity = 1;
                    breakpointEffect.state = BP_PULSE;
                    breakpointEffect.timer = 1.5;
                    breakpointEffect.pulseTime = 0;
                }
                break;

            case BP_PULSE:
                breakpointEffect.timer -= dt;
                breakpointEffect.pulseTime += dt;
                if (breakpointEffect.timer <= 0) {
                    breakpointEffect.state = BP_FADE;
                    breakpointEffect.timer = 0.5;
                    breakpointEffect.opacity = 1;
                }
                break;

            case BP_FADE:
                breakpointEffect.timer -= dt;
                breakpointEffect.opacity = breakpointEffect.timer / 0.5;
                if (breakpointEffect.timer <= 0) {
                    breakpointEffect.opacity = 0;
                    breakpointEffect.state = BP_IDLE;
                    breakpointEffect.timer = randomRange(20, 35);
                    breakpointEffect.orbitIndex = -1;
                    breakpointEffect.tokenIndex = -1;
                }
                break;
        }
    }

    function drawBreakpointDot(orbit, orbitIndex) {
        if (breakpointEffect.state === BP_IDLE || breakpointEffect.orbitIndex !== orbitIndex) return;

        const token = orbit.tokens[breakpointEffect.tokenIndex];
        const angle = orbit.rotation + token.angle;
        const dx = orbit.cx + Math.cos(angle) * orbit.radius;
        const dy = orbit.cy + Math.sin(angle) * orbit.radius;

        // Viewport culling
        if (dx < -10 || dx > w + 10 || dy < -10 || dy > h + 10) return;

        const dark = isDark();
        const redColor = dark ? '#ef4444' : '#dc2626';

        // Calculate radius: base 2px, pulses to 4px during BP_PULSE
        let radius = 2;
        if (breakpointEffect.state === BP_PULSE) {
            // ~2 cycles over 1.5s
            const pulse = Math.sin(breakpointEffect.pulseTime * Math.PI * 2 * (2 / 1.5));
            radius = 2 + 2 * ((pulse + 1) / 2); // oscillates 2→4→2
        }

        ctx.save();
        ctx.globalAlpha = breakpointEffect.opacity;
        ctx.fillStyle = redColor;
        ctx.shadowColor = redColor;
        ctx.shadowBlur = 7 * breakpointEffect.opacity;
        ctx.beginPath();
        ctx.arc(dx, dy, radius, 0, Math.PI * 2);
        ctx.fill();
        ctx.restore();
    }

    function updateTypingEffect(dt) {
        typingEffect.cursorTimer += dt;
        if (typingEffect.cursorTimer >= 0.53) {
            typingEffect.cursorTimer -= 0.53;
            typingEffect.cursorVisible = !typingEffect.cursorVisible;
        }

        switch (typingEffect.state) {
            case TE_IDLE:
                typingEffect.timer -= dt;
                if (typingEffect.timer <= 0) {
                    if (pickTypingTarget()) {
                        typingEffect.state = TE_HIGHLIGHT;
                        typingEffect.timer = 0.5;
                    } else {
                        typingEffect.timer = 2;
                    }
                }
                break;

            case TE_HIGHLIGHT:
                typingEffect.timer -= dt;
                if (typingEffect.timer <= 0) {
                    typingEffect.state = TE_DELETING;
                    typingEffect.charProgress = typingEffect.oldText.length;
                    typingEffect.charTimer = 0;
                }
                break;

            case TE_DELETING:
                typingEffect.charTimer += dt;
                if (typingEffect.charTimer >= 0.1) {
                    typingEffect.charTimer -= 0.1;
                    typingEffect.charProgress--;
                    if (typingEffect.charProgress <= 0) {
                        typingEffect.charProgress = 0;
                        typingEffect.state = TE_PAUSE;
                        typingEffect.timer = 0.3;
                    }
                }
                break;

            case TE_PAUSE:
                typingEffect.timer -= dt;
                if (typingEffect.timer <= 0) {
                    typingEffect.state = TE_TYPING;
                    typingEffect.charProgress = 0;
                    typingEffect.charTimer = 0;
                }
                break;

            case TE_TYPING:
                typingEffect.charTimer += dt;
                if (typingEffect.charTimer >= 0.12) {
                    typingEffect.charTimer -= 0.12;
                    typingEffect.charProgress++;
                    if (typingEffect.charProgress >= typingEffect.newText.length) {
                        typingEffect.charProgress = typingEffect.newText.length;
                        typingEffect.state = TE_HOLD;
                        typingEffect.timer = 1.5;
                        // Update the token text now
                        orbits[typingEffect.orbitIndex].tokens[typingEffect.tokenIndex].text = typingEffect.newText;
                    }
                }
                break;

            case TE_HOLD:
                typingEffect.timer -= dt;
                if (typingEffect.timer <= 0) {
                    typingEffect.state = TE_FADE;
                    typingEffect.fadeProgress = 0;
                }
                break;

            case TE_FADE:
                typingEffect.fadeProgress += dt / 0.5;
                if (typingEffect.fadeProgress >= 1) {
                    typingEffect.state = TE_IDLE;
                    typingEffect.timer = randomRange(15, 25);
                    typingEffect.orbitIndex = -1;
                    typingEffect.tokenIndex = -1;
                }
                break;
        }
    }

    function isTypingTarget(orbitIndex, tokenIndex) {
        return typingEffect.state !== TE_IDLE
            && typingEffect.orbitIndex === orbitIndex
            && typingEffect.tokenIndex === tokenIndex;
    }

    function getTypingDisplayText() {
        const te = typingEffect;
        switch (te.state) {
            case TE_HIGHLIGHT:
                return te.oldText;
            case TE_DELETING:
                return te.oldText.slice(0, te.charProgress);
            case TE_PAUSE:
                return '';
            case TE_TYPING:
                return te.newText.slice(0, te.charProgress);
            case TE_HOLD:
            case TE_FADE:
                return te.newText;
            default:
                return '';
        }
    }

    function drawOrbitLine(orbit) {
        const dark = isDark();
        const alpha = dark ? 0.3 : 0.18;

        ctx.save();
        ctx.strokeStyle = '#71717a';
        ctx.globalAlpha = alpha;
        ctx.lineWidth = 1;
        ctx.beginPath();
        ctx.arc(orbit.cx, orbit.cy, orbit.radius, 0, Math.PI * 2);
        ctx.stroke();

        // Draw tick marks between tokens
        const ticksPerGap = 3;
        const tickHalf = 3; // half-length of each tick (6px total)
        const tokenCount = orbit.tokens.length;

        if (tokenCount > 0) {
            ctx.beginPath();
            for (let i = 0; i < tokenCount; i++) {
                const angleA = orbit.rotation + orbit.tokens[i].angle;
                const angleB = orbit.rotation + orbit.tokens[(i + 1) % tokenCount].angle;

                // Compute the arc gap, handling wrap-around
                let gap = angleB - angleA;
                if (gap <= 0) gap += Math.PI * 2;

                for (let t = 1; t <= ticksPerGap; t++) {
                    const tickAngle = angleA + (gap * t) / (ticksPerGap + 1);
                    const cos = Math.cos(tickAngle);
                    const sin = Math.sin(tickAngle);
                    const tx = orbit.cx + cos * orbit.radius;
                    const ty = orbit.cy + sin * orbit.radius;

                    // Viewport culling
                    if (tx < -10 || tx > w + 10 || ty < -10 || ty > h + 10) continue;

                    ctx.moveTo(
                        orbit.cx + cos * (orbit.radius - tickHalf),
                        orbit.cy + sin * (orbit.radius - tickHalf),
                    );
                    ctx.lineTo(
                        orbit.cx + cos * (orbit.radius + tickHalf),
                        orbit.cy + sin * (orbit.radius + tickHalf),
                    );
                }
            }
            ctx.stroke();
        }

        // Draw node dots at token anchor points
        if (tokenCount > 0) {
            const dotRadius = 2;
            ctx.fillStyle = '#71717a';
            ctx.beginPath();
            for (let i = 0; i < tokenCount; i++) {
                const dotAngle = orbit.rotation + orbit.tokens[i].angle;
                const dx = orbit.cx + Math.cos(dotAngle) * orbit.radius;
                const dy = orbit.cy + Math.sin(dotAngle) * orbit.radius;

                // Viewport culling
                if (dx < -10 || dx > w + 10 || dy < -10 || dy > h + 10) continue;

                ctx.moveTo(dx + dotRadius, dy);
                ctx.arc(dx, dy, dotRadius, 0, Math.PI * 2);
            }
            ctx.fill();
        }

        ctx.restore();
    }

    function drawInteriorLines(orbit) {
        const dark = isDark();
        const alpha = dark ? 0.3 : 0.18;

        ctx.save();
        ctx.strokeStyle = '#71717a';
        ctx.globalAlpha = alpha;
        ctx.lineWidth = 1;

        // Dashed line
        ctx.setLineDash([8, 4]);
        ctx.beginPath();
        ctx.arc(orbit.cx, orbit.cy, orbit.radius - DASHED_LINE_OFFSET, 0, Math.PI * 2);
        ctx.stroke();

        // Dotted line
        ctx.setLineDash([2, 4]);
        ctx.beginPath();
        ctx.arc(orbit.cx, orbit.cy, orbit.radius - DOTTED_LINE_OFFSET, 0, Math.PI * 2);
        ctx.stroke();

        ctx.setLineDash([]);
        ctx.restore();
    }

    function drawCounterRotatingCode(orbit, orbitIndex) {
        const dark = isDark();
        const baseAlpha = dark ? 0.3 : 0.18;
        const codeRadius = orbit.radius - CODE_RADIUS_OFFSET;
        const text = orbit.codeText;
        const fullCircle = Math.PI * 2;

        ctx.font = `${CODE_FONT_SIZE}px "JetBrains Mono", monospace`;

        // Typo effect highlight info for this orbit
        const typoActive = typoEffect.state !== TC_IDLE;
        const highlightSet = typoActive && typoEffect.highlightSets[orbitIndex]
            ? typoEffect.highlightSets[orbitIndex]
            : null;
        const yellowColor = dark ? '#eab308' : '#ca8a04';

        // Primary occurrence info
        let primaryOcc = null;
        if (typoActive && typoEffect.primaryIndex >= 0) {
            const occ = typoEffect.occurrences[typoEffect.primaryIndex];
            if (occ.orbitIndex === orbitIndex) {
                primaryOcc = occ;
            }
        }

        let angle = orbit.counterRotation;
        let charIndex = 0;

        // Lay out characters around the full circle
        while (true) {
            const textIdx = charIndex % text.length;
            let ch = text[textIdx];

            // Check if this char is in the primary override range
            let skipChar = false;
            if (primaryOcc && typoEffect.primaryOverride !== null) {
                const start = primaryOcc.startIndex;
                const wordLen = typoEffect.word.length;
                if (textIdx >= start && textIdx < start + wordLen) {
                    const offsetInWord = textIdx - start;
                    if (offsetInWord < typoEffect.primaryOverride.length) {
                        ch = typoEffect.primaryOverride[offsetInWord];
                    } else {
                        skipChar = true;
                    }
                }
            }

            const charW = getCharWidth(ch, CODE_FONT_SIZE);
            const angularStep = charW / codeRadius;

            // Advance half-step to center character
            angle += angularStep / 2;

            const x = orbit.cx + Math.cos(angle) * codeRadius;
            const y = orbit.cy + Math.sin(angle) * codeRadius;

            // Stop after one full revolution
            if (charIndex > 0 && angle - orbit.counterRotation >= fullCircle) break;

            if (!skipChar && x > -20 && x < w + 20 && y > -20 && y < h + 20) {
                // Determine if this char is highlighted
                const isHighlighted = highlightSet && highlightSet.has(textIdx);

                if (isHighlighted && typoEffect.highlightOpacity > 0) {
                    const hlOpacity = typoEffect.highlightOpacity;
                    ctx.fillStyle = yellowColor;
                    ctx.globalAlpha = baseAlpha + (0.9 - baseAlpha) * hlOpacity;
                    ctx.shadowColor = yellowColor;
                    ctx.shadowBlur = 8 * hlOpacity;
                } else {
                    ctx.fillStyle = '#71717a';
                    ctx.globalAlpha = baseAlpha;
                    ctx.shadowColor = 'transparent';
                    ctx.shadowBlur = 0;
                }

                const cos = Math.cos(angle + Math.PI / 2);
                const sin = Math.sin(angle + Math.PI / 2);
                ctx.setTransform(cos * dpr, sin * dpr, -sin * dpr, cos * dpr, x * dpr, y * dpr);
                ctx.fillText(ch, -charW / 2, CODE_FONT_SIZE * 0.35);
            }

            angle += angularStep / 2;
            charIndex++;
        }

        // Restore standard transform
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function drawAnnotations(orbit) {
        const dark = isDark();
        const alpha = dark ? 0.3 : 0.18;
        const tokenCount = orbit.tokens.length;
        // Position anchor at the dotted line, right-aligned so text extends inward
        const annotR = orbit.radius - DOTTED_LINE_OFFSET - 8;

        ctx.font = `${ANNOTATION_FONT_SIZE}px "JetBrains Mono", monospace`;
        ctx.fillStyle = '#71717a';
        ctx.globalAlpha = alpha;

        for (let i = 0; i < tokenCount; i++) {
            // Line number at same angle as token
            const tokenAngle = orbit.rotation + orbit.tokens[i].angle;
            const lx = orbit.cx + Math.cos(tokenAngle) * annotR;
            const ly = orbit.cy + Math.sin(tokenAngle) * annotR;

            if (lx > -20 && lx < w + 20 && ly > -20 && ly < h + 20) {
                const lineNum = String(orbit.lineNumbers[i]).padStart(3, ' ');
                const textW = getTokenWidth(lineNum, ANNOTATION_FONT_SIZE);
                const cos = Math.cos(tokenAngle);
                const sin = Math.sin(tokenAngle);
                ctx.setTransform(cos * dpr, sin * dpr, -sin * dpr, cos * dpr, lx * dpr, ly * dpr);
                ctx.fillText(lineNum, -textW, ANNOTATION_FONT_SIZE * 0.35);
            }

            // Memory address halfway between this token and the next
            const nextAngle = orbit.tokens[(i + 1) % tokenCount].angle;
            let gap = nextAngle - orbit.tokens[i].angle;
            if (gap <= 0) gap += Math.PI * 2;
            const midAngle = orbit.rotation + orbit.tokens[i].angle + gap / 2;

            const ax = orbit.cx + Math.cos(midAngle) * annotR;
            const ay = orbit.cy + Math.sin(midAngle) * annotR;

            if (ax > -20 && ax < w + 20 && ay > -20 && ay < h + 20) {
                const addrW = getTokenWidth(orbit.addresses[i], ANNOTATION_FONT_SIZE);
                const cos = Math.cos(midAngle);
                const sin = Math.sin(midAngle);
                ctx.setTransform(cos * dpr, sin * dpr, -sin * dpr, cos * dpr, ax * dpr, ay * dpr);
                ctx.fillText(orbit.addresses[i], -addrW, ANNOTATION_FONT_SIZE * 0.35);
            }
        }

        // Restore standard transform
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function drawToken(orbit, token, orbitIndex, tokenIndex) {
        const angle = orbit.rotation + token.angle;
        // Position on the orbit circle
        const ox = orbit.cx + Math.cos(angle) * orbit.radius;
        const oy = orbit.cy + Math.sin(angle) * orbit.radius;

        // Viewport culling
        const margin = 150;
        if (ox < -margin || ox > w + margin || oy < -margin || oy > h + margin) return;

        const dark = isDark();
        const active = isTypingTarget(orbitIndex, tokenIndex);

        // Offset token outward from the orbit line (away from center)
        const nx = Math.cos(angle);
        const ny = Math.sin(angle);
        const tx = ox + nx * TOKEN_OFFSET;
        const ty = oy + ny * TOKEN_OFFSET;

        ctx.save();
        ctx.font = `${orbit.fontSize}px "JetBrains Mono", monospace`;

        if (active) {
            const te = typingEffect;
            const displayText = getTypingDisplayText();

            // Emerald color with optional fade
            let emeraldOpacity = 1;
            if (te.state === TE_FADE) {
                emeraldOpacity = 1 - te.fadeProgress;
            }

            const baseOpacity = dark ? 0.3 : 0.18;
            const activeOpacity = baseOpacity + (0.9 - baseOpacity) * emeraldOpacity;
            const emeraldColor = dark ? '#34d399' : '#059669';
            const normalColor = '#71717a';

            // Interpolate color during fade
            ctx.globalAlpha = activeOpacity;
            ctx.fillStyle = te.state === TE_FADE
                ? lerpColor(emeraldColor, normalColor, te.fadeProgress)
                : emeraldColor;

            // Glow effect
            if (te.state !== TE_FADE || te.fadeProgress < 0.5) {
                ctx.shadowColor = emeraldColor;
                ctx.shadowBlur = 8 * (te.state === TE_FADE ? (1 - te.fadeProgress) : 1);
            }

            ctx.translate(tx, ty);
            ctx.rotate(angle);
            ctx.fillText(displayText, 0, orbit.fontSize * 0.35);

            // Draw cursor
            if (te.state !== TE_FADE && typingEffect.cursorVisible) {
                const cursorX = getTokenWidth(displayText, orbit.fontSize);
                ctx.shadowBlur = 0;
                ctx.fillText('|', cursorX, orbit.fontSize * 0.35);
            }
        } else {
            const opacity = dark ? 0.3 : 0.18;
            ctx.fillStyle = '#71717a';
            ctx.globalAlpha = opacity;

            ctx.translate(tx, ty);
            ctx.rotate(angle);
            ctx.fillText(token.text, 0, orbit.fontSize * 0.35);
        }

        ctx.restore();
    }

    function lerpColor(a, b, t) {
        const parse = (hex) => [
            parseInt(hex.slice(1, 3), 16),
            parseInt(hex.slice(3, 5), 16),
            parseInt(hex.slice(5, 7), 16),
        ];
        const ca = parse(a);
        const cb = parse(b);
        const r = Math.round(ca[0] + (cb[0] - ca[0]) * t);
        const g = Math.round(ca[1] + (cb[1] - ca[1]) * t);
        const bl = Math.round(ca[2] + (cb[2] - ca[2]) * t);
        return `rgb(${r},${g},${bl})`;
    }

    let lastTime = 0;
    let paused = false;
    let resizeTimeout;

    function frame(timestamp) {
        if (paused) {
            lastTime = 0;
            requestAnimationFrame(frame);
            return;
        }

        if (!fontsReady) {
            requestAnimationFrame(frame);
            return;
        }

        const dt = lastTime ? Math.min((timestamp - lastTime) / 1000, 0.05) : 0.016;
        lastTime = timestamp;

        ctx.save();
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.restore();

        updateTypingEffect(dt);
        updateBreakpointEffect(dt);
        updateTypoEffect(dt);

        for (let oi = 0; oi < orbits.length; oi++) {
            const o = orbits[oi];
            o.rotation += o.rotationSpeed * dt;
            o.counterRotation -= o.rotationSpeed * dt;

            drawOrbitLine(o);
            drawBreakpointDot(o, oi);
            drawInteriorLines(o);
            drawCounterRotatingCode(o, oi);
            drawAnnotations(o);

            for (let ti = 0; ti < o.tokens.length; ti++) {
                drawToken(o, o.tokens[ti], oi, ti);
            }
        }

        requestAnimationFrame(frame);
    }

    // Dark mode observer
    new MutationObserver(() => {}).observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class'],
    });

    document.addEventListener('visibilitychange', () => {
        paused = document.hidden;
        if (!paused) lastTime = 0;
    });

    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => resize(), 150);
    });

    resize();
    initOrbits();

    document.fonts.ready.then(() => {
        measureCharWidths();
        fontsReady = true;
    });

    requestAnimationFrame(frame);
}
