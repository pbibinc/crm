import React from "react";

class Input extends React.Component {
    render() {
        const { type, classValue, id, inputValue } = this.props;
        return (
            <input
                type={type}
                className={classValue}
                id={id}
                value={inputValue}
            ></input>
        );
    }
}
export default Input;
