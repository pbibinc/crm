import React from "react";
import "/public/backend/assets/css/bootstrap.min.css";
import "/public/backend/assets/css/icons.min.css";
import "/public/backend/assets/css/app.min.css";

import logo from "/public/backend/assets/images/pibib.png";
import LeadDetails from "../data/lead-details";
const Header = () => {
    const lead = LeadDetails();
    return (
        <header id="page-topbar">
            <div className="navbar-header">
                <div className="d-flex">
                    <div className="navbar-brand-box">
                        {lead?.data?.company_name || "Loading..."}
                    </div>
                </div>
                <div
                    className="d-flex"
                    style={{
                        marginTop: "7%",
                        marginLeft: "-5%",
                    }}
                >
                    <img
                        src={logo}
                        alt="Logo"
                        className="navbar-logo"
                        style={{
                            width: "70%",
                            height: "70%",
                        }}
                    />
                </div>
                <div className="d-flex">{lead?.data?.tel_num}</div>
            </div>
        </header>
    );
};
export default Header;
