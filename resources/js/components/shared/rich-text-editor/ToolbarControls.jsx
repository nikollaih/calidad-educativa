import { h } from 'preact';

export const TEXT_COLORS = [
  { label: 'Negro', value: '#1f2937' },
  { label: 'Azul', value: '#1d4ed8' },
  { label: 'Rojo', value: '#b91c1c' },
  { label: 'Verde', value: '#047857' },
  { label: 'Morado', value: '#7e22ce' },
];

export const HIGHLIGHT_COLORS = [
  { label: 'Amarillo', value: '#fef08a' },
  { label: 'Verde claro', value: '#bbf7d0' },
  { label: 'Azul claro', value: '#bfdbfe' },
  { label: 'Rosa claro', value: '#fecaca' },
];

export const FONT_SIZES = [
  { label: 'Pequeño', value: '12px' },
  { label: 'Normal', value: '16px' },
  { label: 'Mediano', value: '18px' },
  { label: 'Grande', value: '24px' },
  { label: 'Muy grande', value: '32px' },
];

export const FONT_FAMILIES = [
  { label: 'Predeterminada', value: '' },
  { label: 'IBM Plex Sans', value: 'IBM Plex Sans, sans-serif' },
  { label: 'Rubik', value: 'Rubik, sans-serif' },
  { label: 'Arial', value: 'Arial, sans-serif' },
  { label: 'Georgia', value: 'Georgia, serif' },
  { label: 'Monoespaciada', value: 'monospace' },
];

export function ToolbarButton({
  active = false,
  children,
  label,
  onClick,
  disabled = false,
}) {
  return (
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
      }}
      onClick={onClick}
    >
      {children}
    </button>
  );
}

export function FormatSelect({ label, value, options, onChange, disabled }) {
  return (
    <label className="rich-text-editor__select-label">
      <span className="visually-hidden">{label}</span>
      <select
        className="rich-text-editor__select"
        aria-label={label}
        value={value}
        disabled={disabled}
        onChange={(event) => onChange(event.currentTarget.value)}
      >
        {options.map((option) => (
          <option value={option.value} key={option.value}>
            {option.label}
          </option>
        ))}
      </select>
    </label>
  );
}

export function ColorPalette({ label, colors, value, onSelect, onClear, disabled }) {
  return (
    <div className="rich-text-editor__palette" role="group" aria-label={label}>
      <ToolbarButton label={`Quitar ${label.toLowerCase()}`} disabled={disabled} onClick={onClear}>
        A
      </ToolbarButton>
      {colors.map((color) => (
        <ToolbarButton
          key={color.value}
          label={`${label}: ${color.label}`}
          active={value === color.value}
          disabled={disabled}
          onClick={() => onSelect(color.value)}
        >
          <span
            className="rich-text-editor__swatch"
            style={{backgroundColor: color.value}}
            aria-hidden="true"
          />
        </ToolbarButton>
      ))}
    </div>
  );
}
