# Theme-level notes

See `/AGENTS.md` (repo root) for full guidance. Key theme-specific facts:

- Build: `npm run dev` (Vite watch) / `npm run build` (production). Node 24.
- Entry: `assets/scripts/main.js` imports `assets/styles/main.scss`, `editor-style.scss`, `login-style.scss`.
- Output: `dist/bundle.js`, `dist/bundle.css`, `dist/editor-style.js`, `dist/login-style.js`.
- PostCSS config is inside `vite.config.js` (standalone `postcss.config.js` is stale).
- Deploy: `composer install && npm install && npm run build`.
- `.opencode/rules/` has local agent preferences – respect them.
