import React, { useContext, useEffect } from "react";
import "/public/backend/assets/css/bootstrap.min.css";
import "/public/backend/assets/css/icons.min.css";
import "/public/backend/assets/css/app.min.css";
import logo from "/public/backend/assets/images/pibib.png";
import { ContextData } from "../contexts/context-data-provider";

const Header = () => {
    const { lead } = useContext(ContextData);
    if(lead){
        sessionStorage.setItem("lead", JSON.stringify(lead));
    }

    localStorage.setItem("leadId", JSON.stringify(lead?.data?.id));
    const storedLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const storedLeadId = JSON.parse(localStorage.getItem("generalInformationStoredData"));

    if(storedLeadData?.data?.id !== storedLeadId?.id){
        localStorage.removeItem("generalInformationStoredData");
    }

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
                        marginTop: "0%",
                        marginLeft: "0%",
                    }}
                >
                    <img
                        src={logo}
                        alt="Logo"
                        className="navbar-logo"
                        style={{
                            width: "30%",
                            height: "30%",
                        }}
                    />
                </div>
                <div className="d-flex">{lead?.data?.tel_num}</div>
            </div>
        </header>
    );
};
export default Header;
