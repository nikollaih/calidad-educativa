import { h } from 'preact';
import RichTextAdvancedToolbar from './RichTextAdvancedToolbar.jsx';
import { FormatSelect, ToolbarButton } from './ToolbarControls.jsx';

const getBlockFormat = (editor) => {
  for (const level of [1, 2, 3, 4]) {
    if (editor?.isActive('heading', { level })) return `h${level}`;
  }

  return editor?.isActive('codeBlock') ? 'codeBlock' : 'paragraph';
};

/** Primary editing commands; less frequent tools are grouped in the advanced menu. */
export default function RichTextToolbar({ editor, onRequestLink, disabled = false }) {
  const unavailable = !editor || disabled;

  const setBlockFormat = (format) => {
    if (format === 'paragraph') editor.chain().focus().setParagraph().run();
    else if (format === 'codeBlock') editor.chain().focus().toggleCodeBlock().run();
    else editor.chain().focus().setHeading({ level: Number(format.slice(1)) }).run();
  };

  return (
    <div className="rich-text-editor__toolbar" role="toolbar" aria-label="Formato del texto">
      <div className="rich-text-editor__toolbar-primary">
        <FormatSelect
          label="Formato de bloque"
          value={getBlockFormat(editor)}
          disabled={unavailable}
          onChange={setBlockFormat}
          options={[
            { label: 'Párrafo', value: 'paragraph' },
            { label: 'Título 1', value: 'h1' },
            { label: 'Título 2', value: 'h2' },
            { label: 'Título 3', value: 'h3' },
            { label: 'Título 4', value: 'h4' },
            { label: 'Código', value: 'codeBlock' },
          ]}
        />
        <span className="rich-text-editor__separator" aria-hidden="true" />
        <ToolbarButton label="Negrita" disabled={unavailable} active={editor?.isActive('bold')}
          onClick={() => editor?.chain().focus().toggleBold().run()}>
          <strong>B</strong>
        </ToolbarButton>
        <ToolbarButton label="Cursiva" disabled={unavailable} active={editor?.isActive('italic')}
          onClick={() => editor?.chain().focus().toggleItalic().run()}>
          <em>I</em>
        </ToolbarButton>
        <ToolbarButton label="Subrayado" disabled={unavailable} active={editor?.isActive('underline')}
          onClick={() => editor?.chain().focus().toggleUnderline().run()}>
          <u>U</u>
        </ToolbarButton>
        <ToolbarButton label="Tachado" disabled={unavailable} active={editor?.isActive('strike')}
          onClick={() => editor?.chain().focus().toggleStrike().run()}>
          <s>S</s>
        </ToolbarButton>
        <ToolbarButton label="Enlace" disabled={unavailable} active={editor?.isActive('link')}
          onClick={onRequestLink}>
          Enlace
        </ToolbarButton>
      </div>

      <RichTextAdvancedToolbar editor={editor} disabled={disabled} />
    </div>
  );
}
