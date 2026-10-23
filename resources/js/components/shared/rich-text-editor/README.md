# Rich text editor

Reusable Preact rich-text components used by the PEI historical review.

## Components

- `RichTextEditor` wraps Tiptap's framework-agnostic editor. Its `onChange` callback
  receives `(html, visibleCharacterCount)`; editor creation and destruction follow
  the Preact component lifecycle.
- `RichTextToolbar` groups primary actions and delegates advanced commands to
  `RichTextAdvancedToolbar`; shared selects, palettes and buttons live in `ToolbarControls`.
- `LazyRichTextEditor` loads the editor bundle only when the field is mounted.
- `RichTextContent` displays HTML returned by the server-side sanitizer. Do not pass
  arbitrary request or client HTML to it.

The editor supports paragraphs and H1–H4 headings; bold, italic, underline, strike,
subscript, superscript and inline/block code; nested ordered and unordered lists;
block quotes, horizontal rules, safe links and tables; text alignment; preset font
sizes/families, text colors and multicolor highlighting. Advanced commands are
grouped under “Más formato” to keep the toolbar usable in the PEI modal. Images,
embedded media and arbitrary CSS are not enabled.

## Content and security

The editor serializes HTML because the existing PEI views already display HTML.
This output is not trusted: `App\Services\RichTextSanitizer` applies the same
allow-list before database writes, JSON hydration, Blade rendering, and historical
before/after snapshots. The server allows up to 100,000 visible characters and
2,000,000 characters of serialized HTML;
the browser counter uses the visible-text limit. Inline styles are restricted to
alignment, text color, highlight color, font size and font family; color and font
choices in the toolbar use fixed palettes.

Keep the editor's format set and the sanitizer's allow-list in sync when adding
extensions or output tags.
