import { h } from 'preact';
import { useEffect, useRef, useState } from 'preact/hooks';
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import BackgroundColor from '@tiptap/extension-text-style/background-color';
import Color from '@tiptap/extension-color';
import FontFamily from '@tiptap/extension-font-family';
import FontSize from '@tiptap/extension-text-style/font-size';
import Highlight from '@tiptap/extension-highlight';
import Placeholder from '@tiptap/extension-placeholder';
import Subscript from '@tiptap/extension-subscript';
import Superscript from '@tiptap/extension-superscript';
import { TableKit } from '@tiptap/extension-table/kit';
import TextAlign from '@tiptap/extension-text-align';
import { TextStyle } from '@tiptap/extension-text-style';
import RichTextToolbar from './RichTextToolbar.jsx';
import './richTextEditor.css';

const editorExtensions = [
  StarterKit.configure({
    link: {
      openOnClick: false,
    },
  }),
  TextStyle,
  FontSize,
  Color,
  BackgroundColor,
  FontFamily,
  Highlight.configure({ multicolor: true }),
  TextAlign.configure({
    types: ['heading', 'paragraph'],
    alignments: ['left', 'center', 'right', 'justify'],
  }),
  Subscript,
  Superscript,
  TableKit.configure({
    table: {
      resizable: false,
      renderWrapper: false,
    },
  }),
];

const getEditorValue = (editor) => (editor.isEmpty ? '' : editor.getHTML());
const getCharacterCount = (editor) =>
  Array.from(editor.getText({ blockSeparator: '' })).length;

/**
 * Reusable Preact wrapper around Tiptap's framework-agnostic editor instance.
 *
 * `onChange` receives the serialized HTML and its visible character count.
 * The HTML must still be validated and sanitized by the server before storage.
 */
export default function RichTextEditor({
  id,
  label,
  value = '',
  onChange,
  placeholder = 'Escribe aquí…',
  maxLength,
  disabled = false,
  invalid = false,
  describedBy,
}) {
  const mountRef = useRef(null);
  const editorRef = useRef(null);
  const [, refreshToolbar] = useState(0);
  const onChangeRef = useRef(onChange);
  const valueRef = useRef(value);
  const lastValueRef = useRef(value);
  const [linkError, setLinkError] = useState('');
  const statusId = `${id}-status`;
  const helpId = describedBy ? `${describedBy} ${statusId}` : statusId;

  onChangeRef.current = onChange;
  valueRef.current = value;

  useEffect(() => {
    if (!mountRef.current) return undefined;

    const editor = new Editor({
      element: mountRef.current,
      extensions: [
        ...editorExtensions,
        Placeholder.configure({ placeholder }),
      ],
      content: valueRef.current || '<p></p>',
      editable: !disabled,
      editorProps: {
        attributes: {
          id,
          role: 'textbox',
          'aria-label': label,
          'aria-multiline': 'true',
          'aria-invalid': String(invalid),
          'aria-describedby': helpId,
          spellcheck: 'true',
          class: 'rich-text-editor__surface',
        },
      },
      onUpdate: ({ editor: updatedEditor }) => {
        const html = getEditorValue(updatedEditor);
        const characterCount = getCharacterCount(updatedEditor);
        lastValueRef.current = html;
        onChangeRef.current?.(html, characterCount);
        refreshToolbar((version) => version + 1);
      },
      onSelectionUpdate: () => refreshToolbar((version) => version + 1),
    });

    editorRef.current = editor;
    lastValueRef.current = valueRef.current || '';
    onChangeRef.current?.(getEditorValue(editor), getCharacterCount(editor));
    refreshToolbar((version) => version + 1);

    return () => {
      editor.destroy();
      editorRef.current = null;
    };
    // Editor creation is intentionally one-time; mutable props are synchronized below.
  }, []);

  useEffect(() => {
    const editor = editorRef.current;
    if (!editor) return;

    editor.setEditable(!disabled);
    editor.setOptions({
      editorProps: {
        attributes: {
          id,
          role: 'textbox',
          'aria-label': label,
          'aria-multiline': 'true',
          'aria-invalid': String(invalid),
          'aria-describedby': helpId,
          spellcheck: 'true',
          class: 'rich-text-editor__surface',
        },
      },
    });
  }, [describedBy, disabled, id, invalid, label]);

  useEffect(() => {
    const editor = editorRef.current;
    const nextValue = value || '';
    if (!editor || nextValue === lastValueRef.current) return;

    editor.commands.setContent(nextValue || '<p></p>', { emitUpdate: false });
    lastValueRef.current = nextValue;
    onChangeRef.current?.(getEditorValue(editor), getCharacterCount(editor));
  }, [value]);

  const requestLink = () => {
    const editor = editorRef.current;
    if (!editor || disabled) return;

    const currentHref = editor.getAttributes('link').href || '';
    const enteredUrl = window.prompt('Dirección del enlace (http, https o mailto):', currentHref);
    if (enteredUrl === null) return;

    const trimmedUrl = enteredUrl.trim();
    if (!trimmedUrl) {
      editor.chain().focus().extendMarkRange('link').unsetLink().run();
      setLinkError('');
      return;
    }

    let safeUrl;
    try {
      safeUrl = new URL(trimmedUrl, window.location.origin);
    } catch {
      setLinkError('La dirección del enlace no es válida.');
      return;
    }

    if (!['http:', 'https:', 'mailto:'].includes(safeUrl.protocol)) {
      setLinkError('Solo se permiten enlaces http, https o mailto.');
      return;
    }

    editor.chain().focus().extendMarkRange('link').setLink({ href: safeUrl.href }).run();
    setLinkError('');
  };

  const characterCount = editorRef.current ? getCharacterCount(editorRef.current) : 0;
  const isOverLimit = Number.isFinite(maxLength) && characterCount > maxLength;
  return (
    <div
      className={`rich-text-editor${invalid || isOverLimit ? ' is-invalid' : ''}`}
      aria-disabled={disabled}
    >
      <label className="rich-text-editor__label" id={`${id}-label`}>
        {label}
      </label>
      <RichTextToolbar
        editor={editorRef.current}
        onRequestLink={requestLink}
        disabled={disabled}
      />
      <div
        ref={mountRef}
        className="rich-text-editor__mount"
        aria-labelledby={`${id}-label`}
        aria-describedby={helpId}
      />
      <div className="rich-text-editor__footer">
        <small
          id={statusId}
          className={isOverLimit ? 'text-danger' : 'text-muted'}
          aria-live="polite"
        >
          {Number.isFinite(maxLength)
            ? `${characterCount.toLocaleString('es-CO')} / ${maxLength.toLocaleString('es-CO')} caracteres`
            : `${characterCount.toLocaleString('es-CO')} caracteres`}
        </small>
        {linkError && <small className="text-danger" role="alert">{linkError}</small>}
      </div>
    </div>
  );
}
