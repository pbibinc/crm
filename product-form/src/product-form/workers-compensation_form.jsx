import { useContext, useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import Form from "react-bootstrap/Form";
import GeneralInformationData from "../data/general-information-data";

import Select from "react-select";
import InputMask from "react-input-mask";
import { NumericFormat } from "react-number-format";
//import { set } from "lodash";

import DatePicker from "react-datepicker";
import SaveAsIcon from "@mui/icons-material/SaveAs";
import SaveIcon from "@mui/icons-material/Save";

import AsyncStorage from "@react-native-async-storage/async-storage";
import Swal from "sweetalert2";
import axiosClient from "../api/axios.client";
import "../style/general-information.css";
import { ContextData } from "../contexts/context-data-provider";
import { get } from "jquery";
import Button from "react-bootstrap/Button";
import { useWorkersCompensation } from "../contexts/workers-compensation-context";
// import { Audio, ThreeDots } from "react-loader-spinner";

const WorkersCompensationForm = () => {
    const { workersCompensationData } = useWorkersCompensation() || {};

    const { lead } = useContext(ContextData);
    const getWorkersCompensationData = () => {
        let storedData =
            JSON.parse(sessionStorage.getItem("storeWorkersCompData")) || {};
        return workersCompensationData
            ? workersCompensationData[0]
            : storedData;
    };

    //loading variable
    const [isLoading, setIsLoading] = useState(false);

    const generalInfomrationInstance = JSON.parse(
        sessionStorage.getItem("generalInformationStoredData")
    );

    const [totalEmployee, setTotalEmployee] = useState(() =>
        getWorkersCompensationData()?.totalEmployee
            ? getWorkersCompensationData()?.totalEmployee
            : 0
    );

    const [employeeDescription, setEmployeeDescription] = useState(() =>
        getWorkersCompensationData()?.employeeDescription
            ? getWorkersCompensationData()?.employeeDescription
            : [""]
    );

    const [employeeNumber, setEmployeeNumber] = useState(() =>
        getWorkersCompensationData()?.employeeNumber
            ? getWorkersCompensationData()?.employeeNumber
            : [0]
    );

    const leadInstance = JSON.parse(sessionStorage.getItem("lead"));
    const [totalEmployeeSum, setTotalEmployeeSum] = useState(0);
    const [employeePayroll, setEmployeePayroll] = useState(() => {
        const payrollValue = getWorkersCompensationData()?.employeePayroll;
        return payrollValue ? Number(payrollValue) : 0;
    });

    const [ownersPayroll, setOwnersPayroll] = useState(() =>
        getWorkersCompensationData()?.ownersPayroll
            ? getWorkersCompensationData()?.ownersPayroll
            : 0
    );
    const [totalPayroll, setTotalPayroll] = useState(() =>
        getWorkersCompensationData()?.totalPayroll
            ? getWorkersCompensationData()?.totalPayroll
            : employeePayroll
    );
    const [ishaveLossChecked, setIsHaveLossChecked] = useState(false);
    const [haveLossDateOption, setHaveLossDateOption] = useState(1);
    const [payrollDropdownValue, setPayrollDropdownValue] = useState(
        getWorkersCompensationData()?.isOwnerPayrollIncluded || 1
    );

    const [specificDescriptionOfEmployee, setSpecificDescriptionOfEmployee] =
        useState("");
    const [feinValue, setFeinValue] = useState(
        () => getWorkersCompensationData()?.feinValue || ""
    );
    const [ssnValue, setSsnValue] = useState(
        () => getWorkersCompensationData()?.ssnValue || ""
    );

    const [expirationDate, setExpirationDate] = useState(() => {
        const expiration = getWorkersCompensationData()?.expirationDate;
        return expiration && !isNaN(Date.parse(expiration))
            ? new Date(expiration)
            : new Date();
    });

    const [priorCarrier, setPriorCarrier] = useState(
        () => getWorkersCompensationData()?.priorCarrier || ""
    );

    const [workersCompensationAmount, setWorkersCompensationAmount] = useState(
        () => getWorkersCompensationData()?.workersCompensationAmount || ""
    );

    const [policyLimit, setPolicyLimit] = useState(
        () => getWorkersCompensationData()?.policyLimit || 0
    );

    const [eachAccident, setEachAccident] = useState(
        () => getWorkersCompensationData()?.eachAccident || 0
    );

    const [eachEmployee, setEachEmployee] = useState(
        () => getWorkersCompensationData()?.eachEmployee || 0
    );

    const [remarks, setRemarks] = useState(
        () => getWorkersCompensationData()?.remarks || ""
    );
    const [dateofClaim, setDateofClaim] = useState(new Date());
    const [lossAmount, setLossAmount] = useState(0);

    const [isEditing, SetIsEditing] = useState(() =>
        getWorkersCompensationData()?.isUpdate == true ? false : true
    );

    const [isUpdate, SetIsUpdate] = useState(
        () => getWorkersCompensationData()?.isUpdate || false
    );

    const [storedWorkersCompData, setStoredWorkersCompData] = useState(null);

    const [callBackDate, setCallBackDate] = useState(() => {
        const date = getWorkersCompensationData()?.callBackDate;
        return date && !isNaN(Date.parse(date)) ? new Date(date) : new Date();
    });

    const [isCallBack, setIsCallBack] = useState(
        () => getWorkersCompensationData()?.isCallBack || false
    );

    //function for setting up the workers compensation data
    // const workersCompensationData = WorkersCompData();

    useEffect(() => {
        const workersCompLocalData = {
            specificDescriptionOfEmployee: specificDescriptionOfEmployee,
            feinValue: feinValue,
            ssnValue: ssnValue,
            expirationDate: expirationDate,
            priorCarrier: priorCarrier,
            workersCompensationAmount: workersCompensationAmount,
            employeeNumber: employeeNumber,
            employeeDescription: employeeDescription,
            isOwnerPayrollIncluded: {
                value: 1,
                label: "Included",
            },
            policyLimit: {
                value: policyLimit?.value,
                label: policyLimit?.label,
            },
            eachAccident: {
                value: eachAccident?.value,
                label: eachAccident?.label,
            },
            eachEmployee: {
                value: eachEmployee?.value,
                label: eachEmployee?.label,
            },
            remarks: remarks,
            isUpdate: isUpdate,
            isEditing: isEditing,
            dateofClaim: dateofClaim,
            callBackDate: callBackDate,
            isCallBack: isCallBack,

            //payrolll for functionalities
            totalEmployee: totalEmployee,
            totalPayroll: totalPayroll,
            employeePayroll: employeePayroll,
            ownersPayroll: ownersPayroll,
        };

        sessionStorage.setItem(
            "storeWorkersCompData",
            JSON.stringify(workersCompLocalData)
        );
    }, [
        totalEmployee,
        employeeDescription,
        employeeNumber,
        specificDescriptionOfEmployee,
        feinValue,
        ssnValue,
        expirationDate,
        priorCarrier,
        workersCompensationAmount,
        policyLimit,
        eachAccident,
        eachEmployee,
        remarks,
        ishaveLossChecked,
        dateofClaim,
        lossAmount,
        isUpdate,
        isEditing,
        callBackDate,
        isCallBack,
        totalPayroll,
        employeePayroll,
        ownersPayroll,
        payrollDropdownValue,
    ]);

    useEffect(() => {
        const retrieveWorkersCompData = async () => {
            try {
                const value = await AsyncStorage.getItem(
                    "storeWorkersCompData"
                );
                if (value !== null) {
                    setStoredWorkersCompData(JSON.parse(value));
                }
            } catch (e) {
                console.log(e);
            }
        };

        retrieveWorkersCompData();
    }, []);

    //script for computing the value of total employee
    useEffect(() => {
        const storedGeneralInformationInstance = JSON.parse(
            sessionStorage.getItem("generalInformationStoredData") || "{}"
        );
        const totalEmployee = getWorkersCompensationData()?.totalEmployee;
        let fullTime =
            parseInt(storedGeneralInformationInstance.full_time_employee, 10) ||
            0;
        let partTime =
            parseInt(storedGeneralInformationInstance.part_time_employee, 10) ||
            0;
        let allEmployeNumber = fullTime + partTime;
        setTotalEmployeeSum(
            allEmployeNumber ? allEmployeNumber : totalEmployee
        );
    }, []);

    //script for setting the total employee
    useEffect(() => {
        setTotalEmployee(totalEmployeeSum);
    }, [setTotalEmployee, totalEmployeeSum]);

    //script for adding new form
    const addNewEmployeeDescription = () => {
        setEmployeeNumber([...employeeNumber, 0]);
    };

    //script for removing form for employee description
    const removeEmployeeDescription = (index) => {
        const updatedEmployeeNumber = [...employeeNumber];
        updatedEmployeeNumber.splice(index, 1);
        setEmployeeNumber(updatedEmployeeNumber);
    };

    //handles employee number change
    const handleEmployeeNumberChange = (index, event) => {
        const newEmployeeNumber = parseInt(event.target.value, 10) || 0;
        const updatedEmployeeNumbers = [...employeeNumber];
        updatedEmployeeNumbers[index] = newEmployeeNumber;
        setEmployeeNumber(updatedEmployeeNumbers);
    };

    //handle employee number input blur event
    const handleEmployeNumberInputBlur = () => {
        const totalEmployeeNumber = employeeNumber.reduce(
            (sum, number) => sum + number,
            0
        );
        if (totalEmployeeNumber < totalEmployeeSum && totalEmployeeNumber > 0) {
            addNewEmployeeDescription();
        }
    };

    const handleEmployeeDescription = (index, event) => {
        const value = event.target.value;

        const updatedClassCode = [...employeeDescription];
        updatedClassCode[index] = value;
        setEmployeeDescription(updatedClassCode);
    };

    const ownersPayrollOptions = [
        { value: 1, label: "Included" },
        { value: 2, label: "Excluded" },
    ];

    useEffect(() => {
        const storedGeneralInformationInstance = JSON.parse(
            sessionStorage.getItem("generalInformationStoredData") || "{}"
        );
        const payrollEmplyee = getWorkersCompensationData()?.employeePayroll;
        // const payrollOwnerFloat = parseFloat(
        //     storedGeneralInformationInstance.owners_payroll.replace(
        //         /[^0-9.]/g,
        //         ""
        //     )
        // );
        const payrollOwnerFloat =
            storedGeneralInformationInstance.owners_payroll;
        setOwnersPayroll(
            payrollOwnerFloat ? Math.floor(payrollOwnerFloat) : payrollEmplyee
        );
    }, []);

    useEffect(() => {
        const storedGeneralInformationInstance = JSON.parse(
            sessionStorage.getItem("generalInformationStoredData") || "{}"
        );
        const parollEmployee = getWorkersCompensationData()?.employeePayroll;
        // const payrollEmployeeFloat = parseFloat(
        //     storedGeneralInformationInstance.employee_payroll.replace(
        //         /[^0-9.]/g,
        //         ""
        //     )
        // );
        const payrollEmployeeFloat =
            storedGeneralInformationInstance.employee_payroll;
        setEmployeePayroll(
            payrollEmployeeFloat
                ? Math.floor(payrollEmployeeFloat)
                : parollEmployee
        );
    }, []);

    const handlePayrollChange = (event) => {
        const payrollDropdownChange = event.value;
        setPayrollDropdownValue({
            value: event.value,
            label: event.label,
        });

        if (event.value == 1) {
            setTotalPayroll(employeePayroll + ownersPayroll);
        } else {
            setTotalPayroll(employeePayroll);
        }
    };

    const handleHaveLossChange = (event) => {
        setIsHaveLossChecked(event.target.checked);
    };
    const handleCallBackDateSwitch = (event) => {
        setIsCallBack(event.target.checked);
    };

    const dateOptions = [
        { value: 1, label: "MM/DD/YYYY" },
        { value: 2, label: "MM/YYYY" },
    ];

    const handleDateOptionsChange = (event) => {
        setHaveLossDateOption(event.value);
    };

    const limitDropdownOptions = [
        { value: 300000, label: "$300,000" },
        { value: 500000, label: "$500,000" },
        { value: 1000000, label: "$1,000,000" },
    ];

    const workersCompFormData = {
        //workers comp object data common information
        lead_id: leadInstance?.data.id || null,
        userProfileId: leadInstance?.data.userProfileId || null,
        is_owner_payroll_included: payrollDropdownValue.value,
        total_payroll: totalPayroll,
        specific_employee_description: specificDescriptionOfEmployee,
        fein: feinValue,
        ssn: ssnValue,
        expiration: expirationDate,
        prior_carrier: priorCarrier,
        workers_compensation_amount: workersCompensationAmount
            ? parseInt(
                  workersCompensationAmount.replace("$", "").replace(",", "")
              ).toFixed(2) * 100
            : null,
        policy_limit: policyLimit.value,
        each_accident: eachAccident.value,
        each_employee: eachEmployee.value,
        remarks: remarks,

        //workers comp object data for loss
        have_loss: ishaveLossChecked,
        date_of_claim: dateofClaim,
        loss_amount: lossAmount
            ? parseFloat(lossAmount.replace("$", "").replace(",", "")).toFixed(
                  2
              ) * 100
            : null,

        //workers comp object data for employee description per employee
        employee_description: employeeDescription,
        number_of_employee: employeeNumber,
        callBackDate: callBackDate,
        isCallBack: isCallBack,
    };

    function submitWorkersCompensationForm() {
        const generalInformationId = leadInstance?.data.id || null;
        const url = isUpdate
            ? `/api/workers-comp-data/${generalInformationId}`
            : `/api/workers-comp-data/store`;

        const method = isUpdate ? "put" : "post";

        axiosClient[method](url, workersCompFormData)
            .then((response) => {
                setIsLoading(true);
                SetIsEditing(false);
                SetIsUpdate(true);
                if (method == "post") {
                    setIsLoading(false);
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: `Workers Compensation  has been saved`,
                        showConfirmButton: false,
                    });
                } else {
                    setIsLoading(false);
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Workers Compensation has been successfully updated",
                        showConfirmButton: false,
                    });
                }
            })
            .catch((error) => {
                if (error.response.status == 409) {
                    console.log("Error::", error);
                    Swal.fire({
                        icon: "warning",
                        title: `${error.response.data.error}`,
                    });
                } else {
                    console.log("Error::", error);
                    Swal.fire({
                        icon: "warning",
                        title: `Error:: kindly call your IT and Refer to them this error ${error.response.data.error}`,
                    });
                }
            });
    }

    useEffect(() => {
        if (workersCompensationData) {
            const workersCompData = workersCompensationData[0] || {};

            setTotalEmployee(workersCompData.totalEmployee || 0);
            setEmployeeDescription(workersCompData.employeeDescription || [""]);
            setEmployeeNumber(workersCompData.employeeNumber || [0]);
            setTotalEmployeeSum(workersCompData.totalEmployee || 0);
            setEmployeePayroll(Number(workersCompData.employeePayroll) || 0);
            setOwnersPayroll(workersCompData.ownersPayroll || 0);
            setTotalPayroll(workersCompData.totalPayroll || 0);
            setIsHaveLossChecked(workersCompData.ishaveLossChecked || false);
            setHaveLossDateOption(workersCompData.haveLossDateOption || 1);
            setPayrollDropdownValue(
                workersCompData.isOwnerPayrollIncluded || 1
            );
            setSpecificDescriptionOfEmployee(
                workersCompData.specificDescriptionOfEmployee || ""
            );
            setFeinValue(workersCompData.feinValue || "");
            setSsnValue(workersCompData.ssnValue || "");
            setExpirationDate(
                workersCompData.expirationDate
                    ? new Date(workersCompData.expirationDate)
                    : new Date()
            );
            setPriorCarrier(workersCompData.priorCarrier || "");
            setWorkersCompensationAmount(
                workersCompData.workersCompensationAmount || ""
            );
            setPolicyLimit(workersCompData.policyLimit || 0);
            setEachAccident(workersCompData.eachAccident || 0);
            setEachEmployee(workersCompData.eachEmployee || 0);
            setRemarks(workersCompData.remarks || "");
            setDateofClaim(
                workersCompData.dateofClaim
                    ? new Date(workersCompData.dateofClaim)
                    : new Date()
            );
            setLossAmount(workersCompData.lossAmount || 0);
            SetIsEditing(workersCompData.isEditing !== false);
            SetIsUpdate(workersCompData.isUpdate || false);
            setCallBackDate(
                workersCompData.callBackDate
                    ? new Date(workersCompData.callBackDate)
                    : new Date()
            );
            setIsCallBack(workersCompData.isCallBack || false);
        }
    }, [workersCompensationData]);

    return (
        <>
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="totalEmployee"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Total Employee" />
                                <Form.Control
                                    text="number"
                                    disabled={true}
                                    value={totalEmployee}
                                />
                            </>
                        }
                    />,
                ]}
            />
            {employeeNumber.map((employee, index) => (
                <Row
                    key={`employeeDescription${index}`}
                    classValue="mb-3"
                    rowContent={[
                        <Column
                            key="employeeDescription"
                            classValue="col-8"
                            colContent={
                                <>
                                    <Label labelContent="employee description" />
                                    <Form.Control
                                        text="text"
                                        onChange={(event) =>
                                            handleEmployeeDescription(
                                                index,
                                                event
                                            )
                                        }
                                        value={employeeDescription[index]}
                                        disabled={!isEditing}
                                    />
                                </>
                            }
                        />,
                        <Column
                            key="employeeNumber"
                            classValue="col-3"
                            colContent={
                                <>
                                    <Label labelContent="number of employee" />
                                    <Form.Control
                                        text="number"
                                        onChange={(event) =>
                                            handleEmployeeNumberChange(
                                                index,
                                                event
                                            )
                                        }
                                        value={employeeNumber[index]}
                                        disabled={!isEditing}
                                        onBlur={handleEmployeNumberInputBlur}
                                    />
                                </>
                            }
                        />,
                        index > 0 && (
                            <Column
                                key={`removeEmployeeDescriptionButton${index}`}
                                classValue="col-1"
                                colContent={
                                    <>
                                        <Button
                                            onClick={() =>
                                                removeEmployeeDescription(index)
                                            }
                                            className="btn btn-danger"
                                            style={{ marginTop: "31px" }}
                                            disabled={!isEditing}
                                        >
                                            -
                                        </Button>
                                    </>
                                }
                            />
                        ),
                    ]}
                />
            ))}
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="ownersPayrollDropDown"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Is Owner Payroll Included" />
                                <Select
                                    className="basic=single"
                                    classNamePrefix="select"
                                    value={payrollDropdownValue}
                                    options={ownersPayrollOptions}
                                    onChange={handlePayrollChange}
                                    isDisabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="addEmployeeDescription"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Employee Payroll" />
                                <Form.Control
                                    type="text"
                                    value={`$${totalPayroll}`}
                                    disabled={true}
                                />
                            </>
                        }
                    />,
                ]}
            />

            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="keyFeinInputForm"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="FEIN#" />
                                <InputMask
                                    mask="99-9999999"
                                    className="form-control"
                                    value={feinValue}
                                    onBlur={(e) => setFeinValue(e.target.value)}
                                    onChange={(e) =>
                                        setFeinValue(e.target.value)
                                    }
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="keySSNInputForm"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="SSN#" />
                                <InputMask
                                    mask="999-99-9999"
                                    className="form-control"
                                    value={ssnValue}
                                    onBlur={(e) => setSsnValue(e.target.value)}
                                    onChange={(e) =>
                                        setSsnValue(e.target.value)
                                    }
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="workersCompensationExpirationDateColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Expiration of WC" />
                                <br></br>
                                <DatePicker
                                    selected={expirationDate}
                                    onChange={(date) => setExpirationDate(date)}
                                    className="custom-datepicker-input"
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="inputPriorCarrierExpirationDateColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Prior Carrier" />
                                <Form.Control
                                    type="text"
                                    value={priorCarrier}
                                    onChange={(e) =>
                                        setPriorCarrier(e.target.value)
                                    }
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="workersCompAmount"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Workers Comp Amount" />
                                <NumericFormat
                                    className="form-control"
                                    thousandSeparator={true}
                                    prefix={"$"}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                    allowNegative={false}
                                    placeholder="$0.00"
                                    value={workersCompensationAmount}
                                    onChange={(e) =>
                                        setWorkersCompensationAmount(
                                            e.target.value
                                        )
                                    }
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="haveLossColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Have Loss" />
                                <Form.Check
                                    type="switch"
                                    id="haveLossCheckSwitch"
                                    onChange={handleHaveLossChange}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />
            {ishaveLossChecked && (
                <Row
                    classValue="mb-3"
                    rowContent={
                        <Column
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Choose Format" />
                                    <Select
                                        className="basic=single"
                                        classNamePrefix="select"
                                        options={dateOptions}
                                        value={haveLossDateOption}
                                        onChange={handleDateOptionsChange}
                                        isDisabled={!isEditing}
                                    />
                                </>
                            }
                        />
                    }
                />
            )}
            {ishaveLossChecked && (
                <Row
                    classValue="mb-3"
                    rowContent={[
                        <Column
                            key="dateOfLossColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Row
                                        classValue="mb-1"
                                        rowContent={
                                            <Label labelContent="Date of Claim" />
                                        }
                                    />

                                    {haveLossDateOption === 1 && (
                                        <Row
                                            rowContent={
                                                <DatePicker
                                                    selected={dateofClaim}
                                                    showMonthDropdown
                                                    showYearDropdown
                                                    className="custom-datepicker-input"
                                                    onChange={(date) =>
                                                        setDateofClaim(date)
                                                    }
                                                />
                                            }
                                        />
                                    )}

                                    {haveLossDateOption === 2 && (
                                        <Row
                                            rowContent={
                                                <DatePicker
                                                    selected={dateofClaim}
                                                    dateFormat="MM/yyyy"
                                                    showMonthYearPicker
                                                    showMonthDropdown
                                                    showYearDropdown
                                                    className="custom-datepicker-input"
                                                    onChange={(date) =>
                                                        setDateofClaim(date)
                                                    }
                                                    disabled={!isEditing}
                                                />
                                            }
                                        />
                                    )}
                                </>
                            }
                        />,
                        <Column
                            key="lossAmountColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Loss Amount" />
                                    <NumericFormat
                                        value={lossAmount}
                                        className="form-control"
                                        thousandSeparator={true}
                                        prefix={"$"}
                                        decimalScale={2}
                                        fixedDecimalScale={true}
                                        allowNegative={false}
                                        placeholder="$0.00"
                                        onBlur={(e) =>
                                            setLossAmount(e.target.value)
                                        }
                                        disabled={!isEditing}
                                    />
                                </>
                            }
                        />,
                    ]}
                />
            )}

            <Row
                classValue="mb-3"
                rowContent={
                    <>
                        <Label labelContent="Policy Limit" />
                        <Select
                            className="basic=single"
                            classNamePrefix="select"
                            options={limitDropdownOptions}
                            value={policyLimit}
                            onChange={(e) =>
                                setPolicyLimit({
                                    value: e.value,
                                    label: `$${e.value}`,
                                })
                            }
                            isDisabled={!isEditing}
                        />
                    </>
                }
            />

            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="eachAccidentLimit"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Each Accident Limit" />
                                <Select
                                    className="basic=single"
                                    classNamePrefix="select"
                                    options={limitDropdownOptions}
                                    value={eachAccident}
                                    onChange={(e) =>
                                        setEachAccident({
                                            value: e.value,
                                            label: `$${e.value}`,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="eachEmployeeLimit"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Each Employee Limit" />
                                <Select
                                    className="basic=single"
                                    classNamePrefix="select"
                                    options={limitDropdownOptions}
                                    value={eachEmployee}
                                    onChange={(e) =>
                                        setEachEmployee({
                                            value: e.value,
                                            label: `$${e.value}`,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />

            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="generalLiabilitiesEditButtonColumn"
                        classValue="col-12 d-flex justify-content-center align-items-center"
                        colContent={
                            <>
                                <button
                                    size="lg"
                                    onClick={submitWorkersCompensationForm}
                                    disabled={!isEditing}
                                    className="mx-2 form-button"
                                >
                                    <SaveIcon />
                                    <span className="ms-2">Save</span>
                                </button>
                                <button
                                    size="lg"
                                    disabled={isEditing}
                                    onClick={() => SetIsEditing(true)}
                                    className="mx-2 form-button-edit"
                                >
                                    <SaveAsIcon />
                                    <span className="ms-2">Edit</span>
                                </button>
                            </>
                        }
                    />,
                ]}
            />
        </>
    );
};

export default WorkersCompensationForm;
