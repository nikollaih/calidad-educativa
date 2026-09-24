import { h } from "preact";
import { useCallback, useState } from "preact/hooks";
import { useDropzone } from "react-dropzone";

export default function CMultiFileUploader({ onFilesAdded, onFilesDelete }) {
    const [files, setFiles] = useState([]);

    const onDrop = useCallback(
        (acceptedFiles) => {
            setFiles((prev) => [...prev, ...acceptedFiles]);
            if (onFilesAdded) {
                onFilesAdded(acceptedFiles);
            }
        },
        [onFilesAdded]
    );

    const { getRootProps, getInputProps } = useDropzone({
        accept: {
            "image/*": [],
            "application/pdf": [],
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document": [],
        },
        multiple: true,
        onDrop,
    });

    const handleRemoveFile = (fileToRemove) => {
        const updatedFiles = files.filter((f) => f !== fileToRemove);
        setFiles(updatedFiles);
        if (onFilesDelete) {
            onFilesDelete(updatedFiles); // ahora recibe la lista actualizada
        }
    };


    return (
        <div>
            <div
                {...getRootProps({
                    className: "border p-3 text-center rounded bg-light cursor-pointer",
                })}
            >
                <input {...getInputProps()} />
                <p>📂 Arrastra y suelta archivos aquí, o haz clic para seleccionar</p>
            </div>

            {files.length > 0 && (
                <ul className="list-group mt-2">
                    {files.map((file, index) => (
                        <li
                            key={index}
                            className="list-group-item d-flex justify-content-between align-items-center"
                        >
                            <div>
                                <strong>{file.name}</strong>{" "}
                                <small className="text-muted">
                                    ({(file.size / 1024).toFixed(1)} KB)
                                </small>
                            </div>
                            <button
                                type="button"
                                className="btn btn-sm btn-danger"
                                onClick={() => handleRemoveFile(file)}
                            >
                                ❌
                            </button>
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
}
