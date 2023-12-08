import React from "react";
import Form from "react-bootstrap/Form";

class Label extends React.Component {
    render() {
        const { labelContent, forValue } = this.props;
        return (
            <label
                className="control-label col-xs-4"
                // for="{forValue}"
            >
                {labelContent}
            </label>
        );
    }
}

export default Label;
