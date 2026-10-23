import { h } from 'preact';
import { useEffect, useState } from 'preact/hooks';

/** Loads the editor code only on screens that actually open a rich-text field. */
export default function LazyRichTextEditor(props) {
  const [EditorComponent, setEditorComponent] = useState(null);
  const [loadError, setLoadError] = useState(false);

  useEffect(() => {
    let isMounted = true;

    import('./RichTextEditor.jsx').then(({ default: RichTextEditor }) => {
      if (isMounted) setEditorComponent(() => RichTextEditor);
    }).catch(() => {
      if (isMounted) setLoadError(true);
    });

    return () => {
      isMounted = false;
    };
  }, []);

  if (loadError) {
    return <div className="text-danger py-3" role="alert">No fue posible cargar el editor. Recarga la página e inténtalo de nuevo.</div>;
  }

  if (!EditorComponent) {
    return <div className="text-muted py-3" role="status">Cargando editor de texto…</div>;
  }

  return <EditorComponent {...props} />;
}
