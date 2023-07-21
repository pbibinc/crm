import React from "react";

const TextBox = ({ text }) => {
    return (
        <textarea
            className="form-control h-200"
            style={{ resize: "none" }}
            value={text}
            rows="5"
            // cols="20"
        />
    );
};

export default TextBox;
