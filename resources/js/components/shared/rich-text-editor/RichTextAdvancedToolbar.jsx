import { h } from 'preact';
import {
  ColorPalette,
  FONT_FAMILIES,
  FONT_SIZES,
  FormatSelect,
  HIGHLIGHT_COLORS,
  TEXT_COLORS,
  ToolbarButton,
} from './ToolbarControls.jsx';

const ALIGNMENTS = [
  { label: 'Alinear a la izquierda', value: 'left', symbol: '☰' },
  { label: 'Centrar', value: 'center', symbol: '≡' },
  { label: 'Alinear a la derecha', value: 'right', symbol: '☷' },
  { label: 'Justificar', value: 'justify', symbol: '▤' },
];

export default function RichTextAdvancedToolbar({ editor, disabled = false }) {
  const unavailable = !editor || disabled;
  const textStyle = editor?.getAttributes('textStyle') || {};
  const textAlignment = ALIGNMENTS.find(({ value }) =>
    editor?.isActive({ textAlign: value })
  )?.value || 'left';

  return (
    <details className="rich-text-editor__advanced">
      <summary className="rich-text-editor__advanced-toggle">Más formato</summary>
      <div className="rich-text-editor__advanced-panel">
        <div className="rich-text-editor__advanced-group" role="group" aria-label="Alineación">
          {ALIGNMENTS.map(({ label, value, symbol }) => (
            <ToolbarButton
              key={value}
              label={label}
              active={textAlignment === value}
              disabled={unavailable}
              onClick={() => editor?.chain().focus().setTextAlign(value).run()}
            >
              {symbol}
            </ToolbarButton>
          ))}
        </div>

        <FormatSelect
          label="Tamaño de fuente"
          value={textStyle.fontSize || ''}
          disabled={unavailable}
          onChange={(size) => size
            ? editor?.chain().focus().setFontSize(size).run()
            : editor?.chain().focus().unsetFontSize().run()}
          options={[{ label: 'Tamaño', value: '' }, ...FONT_SIZES]}
        />
        <FormatSelect
          label="Familia tipográfica"
          value={textStyle.fontFamily || ''}
          disabled={unavailable}
          onChange={(family) => family
            ? editor?.chain().focus().setFontFamily(family).run()
            : editor?.chain().focus().unsetFontFamily().run()}
          options={FONT_FAMILIES}
        />

        <ColorPalette
          label="Color del texto"
          colors={TEXT_COLORS}
          value={textStyle.color}
          disabled={unavailable}
          onSelect={(color) => editor?.chain().focus().setColor(color).run()}
          onClear={() => editor?.chain().focus().unsetColor().run()}
        />
        <ColorPalette
          label="Resaltado"
          colors={HIGHLIGHT_COLORS}
          value={editor?.getAttributes('highlight').color}
          disabled={unavailable}
          onSelect={(color) => editor?.chain().focus().toggleHighlight({ color }).run()}
          onClear={() => editor?.chain().focus().unsetHighlight().run()}
        />

        <div className="rich-text-editor__advanced-group" role="group" aria-label="Estilos y listas">
          <ToolbarButton
            label="Código en línea"
            active={editor?.isActive('code')}
            disabled={unavailable}
            onClick={() => editor?.chain().focus().toggleCode().run()}
          >
            {'</>'}
          </ToolbarButton>
          <ToolbarButton
            label="Subíndice"
            active={editor?.isActive('subscript')}
            disabled={unavailable}
            onClick={() => editor?.chain().focus().toggleSubscript().run()}
          >
            X<sub>2</sub>
          </ToolbarButton>
          <ToolbarButton
            label="Superíndice"
            active={editor?.isActive('superscript')}
            disabled={unavailable}
            onClick={() => editor?.chain().focus().toggleSuperscript().run()}
          >
            X<sup>2</sup>
          </ToolbarButton>
          <ToolbarButton
            label="Lista con viñetas"
            active={editor?.isActive('bulletList')}
            disabled={unavailable}
            onClick={() => editor?.chain().focus().toggleBulletList().run()}
          >
            • Lista
          </ToolbarButton>
          <ToolbarButton
            label="Lista numerada"
            active={editor?.isActive('orderedList')}
            disabled={unavailable}
            onClick={() => editor?.chain().focus().toggleOrderedList().run()}
          >
            1. Lista
          </ToolbarButton>
          <ToolbarButton
            label="Aumentar sangría de lista"
            disabled={unavailable || !editor?.can().sinkListItem('listItem')}
            onClick={() => editor?.chain().focus().sinkListItem('listItem').run()}
          >
            ⇥ Lista
          </ToolbarButton>
          <ToolbarButton
            label="Disminuir sangría de lista"
            disabled={unavailable || !editor?.can().liftListItem('listItem')}
            onClick={() => editor?.chain().focus().liftListItem('listItem').run()}
          >
            ⇤ Lista
          </ToolbarButton>
          <ToolbarButton
            label="Cita"
            active={editor?.isActive('blockquote')}
            disabled={unavailable}
            onClick={() => editor?.chain().focus().toggleBlockquote().run()}
          >
            Cita
          </ToolbarButton>
          <ToolbarButton
            label="Insertar separador horizontal"
            disabled={unavailable}
            onClick={() => editor?.chain().focus().setHorizontalRule().run()}
          >
            Separador
          </ToolbarButton>
        </div>

        <div className="rich-text-editor__advanced-group" role="group" aria-label="Tablas">
          <ToolbarButton
            label="Insertar tabla de 3 por 3"
            disabled={unavailable}
            onClick={() => editor?.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run()}
          >
            Insertar tabla
          </ToolbarButton>
          {editor?.isActive('table') && (
            <>
              <ToolbarButton label="Agregar fila" disabled={unavailable}
                onClick={() => editor?.chain().focus().addRowAfter().run()}>
                + Fila
              </ToolbarButton>
              <ToolbarButton label="Eliminar fila" disabled={unavailable}
                onClick={() => editor?.chain().focus().deleteRow().run()}>
                − Fila
              </ToolbarButton>
              <ToolbarButton label="Agregar columna" disabled={unavailable}
                onClick={() => editor?.chain().focus().addColumnAfter().run()}>
                + Columna
              </ToolbarButton>
              <ToolbarButton label="Eliminar columna" disabled={unavailable}
                onClick={() => editor?.chain().focus().deleteColumn().run()}>
                − Columna
              </ToolbarButton>
              <ToolbarButton label="Eliminar tabla" disabled={unavailable}
                onClick={() => editor?.chain().focus().deleteTable().run()}>
                Eliminar tabla
              </ToolbarButton>
            </>
          )}
        </div>

        <div className="rich-text-editor__advanced-group" role="group" aria-label="Historial y limpieza">
          <ToolbarButton label="Deshacer" disabled={unavailable || !editor?.can().undo()}
            onClick={() => editor?.chain().focus().undo().run()}>
            ↶ Deshacer
          </ToolbarButton>
          <ToolbarButton label="Rehacer" disabled={unavailable || !editor?.can().redo()}
            onClick={() => editor?.chain().focus().redo().run()}>
            ↷ Rehacer
          </ToolbarButton>
          <ToolbarButton
            label="Limpiar formato"
            disabled={unavailable}
            onClick={() => editor?.chain().focus()
              .clearNodes()
              .unsetAllMarks()
              .unsetTextAlign()
              .unsetColor()
              .unsetBackgroundColor()
              .unsetFontSize()
              .unsetFontFamily()
              .run()}
          >
            Limpiar formato
          </ToolbarButton>
        </div>
      </div>
    </details>
  );
}
