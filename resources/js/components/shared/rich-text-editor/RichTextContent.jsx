import { h } from 'preact';
import './richTextContent.css';

/**
 * Displays HTML that has already passed through the server-side rich-text sanitizer.
 * Never pass arbitrary client or request content to this component.
 */
export default function RichTextContent({ html, className = '', emptyMessage = 'No registrado' }) {
  if (!html) {
    return <span className="text-muted fst-italic">{emptyMessage}</span>;
  }

  return (
    <div
      className={`pei-rich-text ${className}`.trim()}
      dangerouslySetInnerHTML={{__html: html}}
    />
  );
}
