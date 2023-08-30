import React from "react";

class Card extends React.Component {
    render() {
        const { headerContent, bodyContent } = this.props;
        return (
            <div className="card">
                <div className="card-header">
                    <h3>{headerContent}</h3>
                </div>
                <div className="card-body">{bodyContent}</div>
                {/*  */}
            </div>
        );
    }
}

export default Card;
