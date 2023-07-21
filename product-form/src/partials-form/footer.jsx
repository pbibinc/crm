import React from "react";

import "/public/backend/assets/css/bootstrap.min.css";
import "/public/backend/assets/css/icons.min.css";
import "/public/backend/assets/css/app.min.css";

const Footer = () => {
    return (
        <footer className="footer">
            <div className="container-fluid">
                <div className="row">
                    <div className="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script>{" "}
                        © IT DEPARTMENT INSURAPRIME.
                    </div>
                    <div className="col-sm-6">
                        <div className="text-sm-end d-none d-sm-block">
                            Crafted with{" "}
                            <i className="mdi mdi-heart text-danger"></i> by
                            InsuraPrime Dev
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    );
};

export default Footer;
