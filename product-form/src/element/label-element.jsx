import React from "react";
import Form from 'react-bootstrap/Form';


class Label extends React.Component {
    render() {
        const { labelContent, forValue } = this.props;
        return <Form.Label  htmlFor={forValue}  style={{ color: 'gray', fontWeight: 500 }}>{labelContent}</Form.Label>;
    }
}

export default Label;