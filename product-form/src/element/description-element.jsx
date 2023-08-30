import React from "react";

const TextBox = ({ text, onBlur, disabled }) => {
    return (
        <textarea
            className="form-control h-200"
            style={{ resize: "none" }}
            value={text}
            rows="5"
            onBlur={onBlur}
            disabled={disabled}
            // cols="20"
        />
    );
};

export default TextBox;
