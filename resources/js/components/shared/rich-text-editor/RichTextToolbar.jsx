import { h } from 'preact';

const ToolbarButton = ({
  active = false,
  children,
  label,
  onClick,
  onMouseDown,
  disabled = false,
}) => (
  <button
    type="button"
    className={`rich-text-editor__button${active ? ' is-active' : ''}`}
    title={label}
    aria-label={label}
    aria-pressed={active}
    disabled={disabled}
    onMouseDown={(event) => {
      // Keep the editor selection while the user activates a toolbar command.
      event.preventDefault();
      onMouseDown?.(event);
    }}
    onClick={onClick}
  >
    {children}
  </button>
);

/** Toolbar for the deliberately small, semantic format set used by the PEI editor. */
export default function RichTextToolbar({ editor, onRequestLink, disabled = false }) {
  const unavailable = !editor || disabled;

  return (
    <div className="rich-text-editor__toolbar" role="toolbar" aria-label="Formato del texto">
      <ToolbarButton
        label="Párrafo"
        disabled={unavailable}
        active={editor?.isActive('paragraph')}
        onClick={() => editor?.chain().focus().setParagraph().run()}
      >
        P
      </ToolbarButton>
      <ToolbarButton
        label="Título 2"
        disabled={unavailable}
        active={editor?.isActive('heading', { level: 2 })}
        onClick={() => editor?.chain().focus().toggleHeading({ level: 2 }).run()}
      >
        H2
      </ToolbarButton>
      <ToolbarButton
        label="Título 3"
        disabled={unavailable}
        active={editor?.isActive('heading', { level: 3 })}
        onClick={() => editor?.chain().focus().toggleHeading({ level: 3 }).run()}
      >
        H3
      </ToolbarButton>

      <span className="rich-text-editor__separator" aria-hidden="true" />

      <ToolbarButton
        label="Negrita"
        disabled={unavailable}
        active={editor?.isActive('bold')}
        onClick={() => editor?.chain().focus().toggleBold().run()}
      >
        <strong>B</strong>
      </ToolbarButton>
      <ToolbarButton
        label="Cursiva"
        disabled={unavailable}
        active={editor?.isActive('italic')}
        onClick={() => editor?.chain().focus().toggleItalic().run()}
      >
        <em>I</em>
      </ToolbarButton>
      <ToolbarButton
        label="Subrayado"
        disabled={unavailable}
        active={editor?.isActive('underline')}
        onClick={() => editor?.chain().focus().toggleUnderline().run()}
      >
        <u>U</u>
      </ToolbarButton>
      <ToolbarButton
        label="Tachado"
        disabled={unavailable}
        active={editor?.isActive('strike')}
        onClick={() => editor?.chain().focus().toggleStrike().run()}
      >
        <s>S</s>
      </ToolbarButton>

      <span className="rich-text-editor__separator" aria-hidden="true" />

      <ToolbarButton
        label="Lista con viñetas"
        disabled={unavailable}
        active={editor?.isActive('bulletList')}
        onClick={() => editor?.chain().focus().toggleBulletList().run()}
      >
        • Lista
      </ToolbarButton>
      <ToolbarButton
        label="Lista numerada"
        disabled={unavailable}
        active={editor?.isActive('orderedList')}
        onClick={() => editor?.chain().focus().toggleOrderedList().run()}
      >
        1. Lista
      </ToolbarButton>
      <ToolbarButton
        label="Cita"
        disabled={unavailable}
        active={editor?.isActive('blockquote')}
        onClick={() => editor?.chain().focus().toggleBlockquote().run()}
      >
        Cita
      </ToolbarButton>
      <ToolbarButton
        label="Enlace"
        disabled={unavailable}
        active={editor?.isActive('link')}
        onClick={onRequestLink}
      >
        Enlace
      </ToolbarButton>

      <span className="rich-text-editor__separator" aria-hidden="true" />

      <ToolbarButton
        label="Deshacer"
        disabled={unavailable || !editor?.can().undo()}
        onClick={() => editor?.chain().focus().undo().run()}
      >
        ↶
      </ToolbarButton>
      <ToolbarButton
        label="Rehacer"
        disabled={unavailable || !editor?.can().redo()}
        onClick={() => editor?.chain().focus().redo().run()}
      >
        ↷
      </ToolbarButton>
      <ToolbarButton
        label="Limpiar formato"
        disabled={unavailable}
        onClick={() => editor?.chain().focus().clearNodes().unsetAllMarks().run()}
      >
        Limpiar
      </ToolbarButton>
    </div>
  );
}
