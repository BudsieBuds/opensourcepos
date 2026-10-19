# Open Source Point of Sale — Website & Documentation (`gh-pages`)

[![Website](https://img.shields.io/website?url=https%3A%2F%2Fopensourcepos.org&label=opensourcepos.org)](https://opensourcepos.org)
[![Astro](https://img.shields.io/badge/Astro-5.x-BC52EE.svg?logo=astro&logoColor=white)](https://astro.build)
[![Built with Starlight](https://astro.badg.es/v2/built-with-starlight/tiny.svg)](https://starlight.astro.build)
[![Node.js Version](https://img.shields.io/badge/node-%3E%3D20.0.0-brightgreen.svg)](https://nodejs.org)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://github.com/opensourcepos/opensourcepos/blob/master/LICENSE)

> [!NOTE]
> **Branch Purpose**: This branch (`gh-pages`) hosts the official marketing website, user manuals, hardware guides, and developer documentation for [Open Source Point of Sale (OSPOS)](https://opensourcepos.org). The main PHP/CodeIgniter 4 application codebase lives on the [`master`](https://github.com/opensourcepos/opensourcepos/tree/master) branch.

---

## 📖 Architecture & Technology Stack

The website is engineered with modern static site generation tooling:

- **Framework**: [Astro 5](https://astro.build/) with [Starlight](https://starlight.astro.build/) documentation engine.
- **Search**: Built-in [Pagefind](https://pagefind.app/) static search index (zero external API dependencies, fully offline, generated at build time).
- **Styling**: Standard Starlight theme with responsive design, automatic dark/light mode switching, and official OSPOS branding SVG assets.
- **Diagrams & Math**: Built-in support for [Mermaid.js](https://mermaid.js.org/) flowcharts/sequence diagrams and [KaTeX](https://katex.org/) LaTeX mathematical formulas.
- **Hosting**: GitHub Pages serving custom apex domain `opensourcepos.org` via `public/CNAME`.

---

## 🚀 Quick Start for Contributors

### Prerequisites
- **Node.js**: `20.x` or `22.x` (LTS recommended)
- **npm**: `10.x` or later

### Installation & Local Development

```bash
# 1. Clone or switch to the gh-pages branch
git checkout gh-pages

# 2. Install dependencies
npm install

# 3. Start local development server with hot-reloading
npm run dev

# 4. Open http://localhost:4321 in your browser
```

> [!TIP]
> You can also start the Astro development server in background mode:
> ```bash
> npx astro dev --background
> ```
> Inspect status or stop with `npx astro dev status` and `npx astro dev stop`.

---

## 🛠️ Project Structure

```text
.
├── public/
│   ├── CNAME                       # Domain routing (opensourcepos.org)
│   └── favicon.svg                 # Official brand emblem favicon
├── src/
│   ├── assets/                     # Brand SVG marks (logo.svg, logo-white.svg)
│   ├── content/
│   │   ├── docs/                   # Markdown documentation pages & landing page
│   │   │   ├── index.mdx           # Homepage & feature showcase
│   │   │   ├── getting-started/    # Installation, Docker, Pi, Windows, Upgrading
│   │   │   ├── user-guide/         # Register, Inventory, Kits, Attributes, Due, Cashups
│   │   │   ├── hardware/           # Printers, Scanners, Drawers, Scales, Displays
│   │   │   ├── configuration/      # Store settings, Taxes, Security, Barcodes, Email
│   │   │   ├── developer/          # CI4 Architecture, DB Migrations, Testing, API
│   │   │   └── troubleshooting/    # Common issues, Printing, Database recovery
│   │   └── i18n/                   # Starlight UI internationalization strings
│   └── content.config.ts           # Astro content collection schemas (docs, i18n)
├── astro.config.mjs                # Starlight navigation sidebar, social links, plugins
├── package.json                    # Scripts and dependencies
└── tsconfig.json                   # TypeScript configuration
```

---

## 🔄 Keeping This Branch Up to Date

### 1. Updating Dependencies (Astro & Starlight)

To upgrade Astro, Starlight, and related Vite/Markdown plugins to their latest versions:

```bash
# Check for outdated packages
npm outdated

# Automated upgrade via official Astro CLI tool:
npx @astrojs/upgrade

# Or manually update all dependencies to compatible versions:
npm update

# Verify the production build compiles cleanly after updates:
npm run build
```

> [!IMPORTANT]
> Always run `npm run build` after upgrading packages to ensure that Pagefind indexing and content collection schemas continue to pass without warnings or errors.

---

### 2. Keeping Documentation in Sync with `master`

When new features, configuration options, or architectural changes are merged into the `master` branch of OSPOS:

1. **Inspect Changes on `master`**:
   - Compare release tags or commits: `git diff v3.4.0..master`
   - Check `app/Config/` and `.env.example` for newly added configuration keys.
   - Check `app/Controllers/` and `app/Libraries/` for new endpoints or business logic.
   - Check `app/Database/Migrations/` for schema alterations.
2. **Update the Relevant Guide**:
   - If an `.env` variable was added: update `src/content/docs/configuration/security-and-environment.md`.
   - If a new Store Config setting was created: update `src/content/docs/configuration/store-settings.md`.
   - If a new hardware device or printer protocol is supported: update `src/content/docs/hardware/`.
3. **Verify Code Claims**:
   - Verify all documented tokens, formulas, and constant values directly against the code (e.g. `Token_lib.php`, `Sale_lib.php`, `Constants.php`).
4. **Test the Build**:
   ```bash
   npm run build
   ```

---

## ✍️ Authoring & Contribution Guidelines

### Adding a New Document

1. Create a markdown file (`.md` or `.mdx`) in the appropriate subfolder under `src/content/docs/`.
2. Include the required YAML frontmatter:
   ```yaml
   ---
   title: Page Title
   description: Concise 1-sentence summary for search engines and social cards.
   ---
   ```
3. Register the new page in `astro.config.mjs` under the appropriate sidebar group:
   ```javascript
   { label: 'My Page Title', slug: 'user-guide/my-page-title' }
   ```
4. Verify internal links and anchor references.

### Formatting Conventions

- **Internal Links**: Use absolute root-relative paths ending with a trailing slash (e.g., `[Item Kits](/user-guide/item-kits/)`). Do not append `.md`.
- **Keyboard Shortcuts**: Use HTML `<kbd>` elements (e.g., `<kbd>ALT</kbd> + <kbd>1</kbd>`).
- **Admonitions / Callouts**: Use Starlight callouts for emphasis:
  ```markdown
  :::note
  Standard informational note.
  :::

  :::tip
  Best practice or pro-tip.
  :::

  :::caution
  Potential risk or important prerequisite.
  :::
  ```
- **Math & Formulas**: Use standard KaTeX syntax:
  ```markdown
  $$\text{Discrepancy} = \text{Counted Cash} - \text{Expected Cash}$$
  ```
- **Diagrams**: Use Mermaid diagrams inside ````mermaid```` code blocks.

---

## 🧞 Available Scripts

| Command | Action |
| :--- | :--- |
| `npm run dev` | Starts local dev server at `http://localhost:4321` with hot-reloading |
| `npm run build` | Compiles static HTML, optimizes images, and generates Pagefind search index into `dist/` |
| `npm run preview` | Locally serves and tests the compiled static build from `dist/` |
| `npx astro check` | Runs diagnostic type checking on content and configuration |

---

## 📄 License

The website content and documentation are licensed under the [MIT License](https://github.com/opensourcepos/opensourcepos/blob/master/LICENSE).
The Open Source Point of Sale application is licensed under the [MIT License](https://github.com/opensourcepos/opensourcepos/blob/master/LICENSE).
