import React from "react";

class SelectElement extends React.Component {
    render() {
        const {
            optionContent,
            classValue,
            id,
            name,
            onChangeValue,
            optionValue,
        } = this.props;
        return (
            <select
                className={classValue}
                id={id}
                name={name}
                onChange={onChangeValue}
            >
                <option value={optionValue}>{optionContent}</option>
            </select>
        );
    }
}

export default SelectElement;
