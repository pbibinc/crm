import React from "react";

class Column extends React.Component {
    render() {
        const { colContent, classValue } = this.props;
        return <div className={classValue}>{colContent}</div>;
    }
}

export default Column;
