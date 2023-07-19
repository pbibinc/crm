import React from "react";

class Row extends React.Component {
    render() {
        const { rowContent, classValue } = this.props;
        return <div className={`row ${classValue}`}>{rowContent}</div>;
    }
}

export default Row;
