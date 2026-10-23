# Rich text editor

Reusable Preact rich-text components used by the PEI historical review.

## Components

- `RichTextEditor` wraps Tiptap's framework-agnostic editor. Its `onChange` callback
  receives `(html, visibleCharacterCount)`; editor creation and destruction follow
  the Preact component lifecycle.
- `RichTextToolbar` contains the supported semantic editing commands.
- `LazyRichTextEditor` loads the editor bundle only when the field is mounted.
- `RichTextContent` displays HTML returned by the server-side sanitizer. Do not pass
  arbitrary request or client HTML to it.

The editor supports paragraphs, H2/H3 headings, bold, italic, underline, strike,
ordered and unordered lists, block quotes, safe links, undo/redo, and clearing
formatting. Images, embedded media, code blocks, and arbitrary styles are not enabled.

## Content and security

The editor serializes HTML because the existing PEI views already display HTML.
This output is not trusted: `App\Services\RichTextSanitizer` applies the same
allow-list before database writes, JSON hydration, and Blade rendering. The server
allows up to 100,000 visible characters and 2,000,000 characters of serialized HTML;
the browser counter uses the visible-text limit.

Keep the editor's format set and the sanitizer's allow-list in sync when adding
extensions or output tags.
