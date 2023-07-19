import React from "react";

class Label extends React.Component {
    render() {
        const { labelContent, forValue } = this.props;
        return <label htmlFor={forValue}>{labelContent}</label>;
    }
}

export default Label;
