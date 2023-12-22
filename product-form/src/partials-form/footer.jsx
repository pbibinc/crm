import React, { useContext, useState } from "react";

import "/public/backend/assets/css/bootstrap.min.css";
import "/public/backend/assets/css/icons.min.css";
import "/public/backend/assets/css/app.min.css";
import Button from "react-bootstrap/Button";
import SaveAsIcon from "@mui/icons-material/SaveAs";
import Modal from "react-bootstrap/Modal";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import DatePicker from "react-datepicker";
import Form from "react-bootstrap/Form";
import axiosClient from "../api/axios.client";
import Swal from "sweetalert2";
import "../style/footer-style.css";
import { ContextData } from "../contexts/context-data-provider";

const Footer = () => {
    const { authToken, user } = useContext(ContextData);

    const [showModal, setShowModal] = useState(false);

    const handleOpenModal = () => setShowModal(true);
    const handleCloseModal = () => setShowModal(false);
    console.log("authToken", authToken);
    const footerStyle = {};

    //variable for remarks and date of claim
    const [remarks, setRemarks] = useState("");
    const [callBackDate, setCallBackDate] = useState(new Date());
    // Get the time zone offset in minutes
    const timeZoneOffset = callBackDate.getTimezoneOffset();
    const adjustedDate = new Date(
        callBackDate.getTime() - timeZoneOffset * 60000
    );
    const leadInstance = JSON.parse(sessionStorage.getItem("lead"));
    const formattedDate = adjustedDate
        .toISOString()
        .slice(0, 19)
        .replace("T", " ");
    const formData = {
        callBackRemarks: remarks,
        dateTime: formattedDate,
        status: 1,
        type: 1,
        leadId: leadInstance?.data?.id,
    };

    function submitCallback() {
        console.log(formData);
        axiosClient
            .post("/api/callback/store", formData)
            .then((response) => {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: `Call Back has been set`,
                }).then((result) => {
                    setShowModal(false);
                });
            })
            .catch((error) => {
                Swal.fire({
                    icon: "warning",
                    title: `Error setting Call Back`,
                });
            });
    }

    const handleCloseButton = () => {
        window.close();
    };

    return (
        <div className="footerDiv">
            <div className="row">
                <div className="col-5">
                    {" "}
                    <button
                        size="lg"
                        className="mx-2 form-button-close"
                        onClick={handleCloseButton}
                    >
                        CLOSE
                    </button>
                </div>
                <div className="col-7">
                    <button
                        size="lg"
                        className="mx-2 form-button-callback"
                        onClick={handleOpenModal}
                    >
                        Schedule Callback
                    </button>
                </div>
            </div>
            <div className="craftedWithStyle">
                Crafted with <i className="mdi mdi-heart text-danger"></i> by
                InsuraPrime Dev
            </div>

            <Modal show={showModal} onHide={handleCloseModal}>
                <Modal.Header closeButton>
                    <Modal.Title>Schedule A Callback</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    {" "}
                    <Row
                        classValue="mb-4"
                        rowContent={[
                            <Column
                                key="callBackDateColumn"
                                classValue="col-12"
                                colContent={
                                    <>
                                        <Row
                                            classValue="mb-1"
                                            rowContent={
                                                <Label labelContent="Call Back Date" />
                                            }
                                        />
                                        <Row
                                            rowContent={
                                                <DatePicker
                                                    showMonthDropdown
                                                    showYearDropdown
                                                    className="custom-datepicker-input"
                                                    selected={callBackDate}
                                                    onChange={(date) =>
                                                        setCallBackDate(date)
                                                    }
                                                    showTimeSelect // Enable time selection
                                                    timeFormat="HH:mm" // Set the time format
                                                    timeIntervals={15} // Specify time intervals (optional)
                                                    dateFormat="MM:dd:yyyy h:mm aa" // Date and time format
                                                />
                                            }
                                        />
                                    </>
                                }
                            />,
                        ]}
                    />
                    <Row
                        classValue="mb-4"
                        rowContent={[
                            <Column
                                key="callBackDateColumn"
                                classValue="col-12"
                                colContent={
                                    <>
                                        <Label labelContent="Remarks" />
                                        <Form.Control
                                            as={"textarea"}
                                            rows={6}
                                            value={remarks}
                                            onChange={(e) =>
                                                setRemarks(e.target.value)
                                            }
                                        />
                                    </>
                                }
                            />,
                        ]}
                    />
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="secondary" onClick={handleCloseModal}>
                        Close
                    </Button>
                    <Button variant="primary" onClick={submitCallback}>
                        Save Changes
                    </Button>
                </Modal.Footer>
            </Modal>
        </div>
    );
};

export default Footer;
