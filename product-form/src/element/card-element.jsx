import React from "react";

class CardElement extends React.Component {
    render() {
        const { headerContent, bodyContent } = this.props;
        const titleStyle = {
            color: "white",
        };
        const headerStyle = {
            backgroundColor: "#064367",
        };
        return (
            <div className="card">
                <div className="card-header" style={headerStyle}>
                    <h6 style={titleStyle}>{headerContent}</h6>
                </div>
                <div className="card-body">{bodyContent}</div>
                {/*  */}
            </div>
        );
    }
}
export default CardElement;
