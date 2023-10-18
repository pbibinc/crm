import { useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import Form from "react-bootstrap/Form";
import GeneralInformationData from "../data/general-information-data";
import Button from "react-bootstrap/Button";
import Select from "react-select";
import InputMask from "react-input-mask";

import DateTime from "../element/date-time";
import DateDay from "../element/date-day";
import { NumericFormat } from "react-number-format";
import { set } from "lodash";
import DateMonth from "../element/date-month";
import DatePicker from "react-datepicker";
import SaveAsIcon from "@mui/icons-material/SaveAs";
import SaveIcon from "@mui/icons-material/Save";
import axios from "axios";
import WorkersCompData from "../data/workers-comp-data";
import AsyncStorage from "@react-native-async-storage/async-storage";
import Swal from 'sweetalert2'

const WorkersCompensationForm = () => {
    const getWorkersCompensationData = () => {
        let storedData = JSON.parse(sessionStorage.getItem("storeWorkersCompData")) || {};
        return storedData;
    };

    const generalInfomrationInstance = JSON.parse(sessionStorage.getItem("generalInformationStoredData"));
    const [totalEmployee, setTotalEmployee] = useState(0);
    const [employeeDescription, setEmployeeDescription] = useState("");
    const [employeeNumber, setEmployeeNumber] = useState([0]);

    const leadInstance = JSON.parse(sessionStorage.getItem("lead"));
    const [totalEmployeeSum, setTotalEmployeeSum] = useState(0);
    const [employeePayroll, setEmployeePayroll] = useState(0);
    const [ownersPayroll, setOwnersPayroll] = useState(0);
    const [totalPayroll, setTotalPayroll] = useState(employeePayroll);
    const [ishaveLossChecked, setIsHaveLossChecked] = useState(false);
    const [haveLossDateOption, setHaveLossDateOption] = useState(1);
    const [payrollDropdownValue, setPayrollDropdownValue] = useState(2);
    const [specificDescriptionOfEmployee, setSpecificDescriptionOfEmployee] =
        useState("");
    const [feinValue, setFeinValue] = useState(() => getWorkersCompensationData()?.feinValue || "");
    const [ssnValue, setSsnValue] = useState(() => getWorkersCompensationData()?.ssnValue || "");

    const [expirationDate, setExpirationDate] = useState(() => {
        const expiration = getWorkersCompensationData()?.expirationDate;
        return expiration && !isNaN(Date.parse(expiration)) ? new Date(expiration) : new Date();
    });
    const [priorCarrier, setPriorCarrier] = useState(() => getWorkersCompensationData()?.priorCarrier || "");
    const [workersCompensationAmount, setWorkersCompensationAmount] =
        useState(() => getWorkersCompensationData()?.workersCompensationAmount || "");


    const [policyLimit, setPolicyLimit] = useState(() => getWorkersCompensationData()?.policyLimit || 0);

    const [eachAccident, setEachAccident] = useState(() => getWorkersCompensationData()?.eachAccident || 0);

    const [eachEmployee, setEachEmployee] = useState(() => getWorkersCompensationData()?.eachEmployee || 0);

    const [remarks, setRemarks] = useState(() => getWorkersCompensationData()?.remarks || "");
    const [dateofClaim, setDateofClaim] = useState(new Date());
    const [lossAmount, setLossAmount] = useState(0);

    const [isEditing, SetIsEditing] = useState(() => getWorkersCompensationData()?.isUpdate == true ? false : true);

    const [isUpdate, SetIsUpdate] = useState(() => getWorkersCompensationData()?.isUpdate || false);

    const [storedWorkersCompData, setStoredWorkersCompData] = useState(null);

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
            policyLimit: {value: policyLimit?.value, label: policyLimit?.label},
            eachAccident: {value: eachAccident?.value, label: eachAccident?.label},
            eachEmployee: {value: eachEmployee?.value, label: eachEmployee?.label},
            remarks: remarks,
            isUpdate: isUpdate,
            isEditing: isEditing,
            dateofClaim: dateofClaim,
        };

        sessionStorage.setItem("storeWorkersCompData", JSON.stringify(workersCompLocalData));
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
        isEditing
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

    {
        /* Code for Settting up the Emmployeee number and Employee Dynamic from */
    }
    //script for computing the value of total employee
    useEffect(() => {
        const storedGeneralInformationInstance = JSON.parse(sessionStorage.getItem("generalInformationStoredData") || "{}");
            let fullTime = parseInt(storedGeneralInformationInstance.full_time_employee, 10) || 0;
            let partTime = parseInt(storedGeneralInformationInstance.part_time_employee, 10) || 0;
            setTotalEmployeeSum(fullTime + partTime);
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

    {
        /* End of Employee number */
    }
    {
        /* Setup Computing total employee payroll*/
    }
    const ownersPayrollOptions = [
        { value: 1, label: "Included" },
        { value: 2, label: "Excluded" },
    ];

    useEffect(() => {
        const storedGeneralInformationInstance = JSON.parse(sessionStorage.getItem("generalInformationStoredData") || "{}");
        const payrollOwnerFloat = parseFloat(storedGeneralInformationInstance.owners_payroll.replace(/[^0-9.]/g, ''));
        setOwnersPayroll(Math.floor(payrollOwnerFloat));
    }, []);

    useEffect(() => {
        const storedGeneralInformationInstance = JSON.parse(sessionStorage.getItem("generalInformationStoredData") || "{}");
        const payrollEmployeeFloat = parseFloat(storedGeneralInformationInstance.employee_payroll.replace(/[^0-9.]/g, ''));
        setEmployeePayroll(Math.floor(payrollEmployeeFloat));
    }, []);

    const handlePayrollChange = (event) => {
        const payrollDropdownChange = event.value;
        setPayrollDropdownValue(payrollDropdownChange);

        if (payrollDropdownChange === 1) {
            setTotalPayroll(employeePayroll + ownersPayroll);
        } else  {
            setTotalPayroll(employeePayroll);
        }
    };



    {
        /* Ending Setup Computing total employee payroll*/
    }

    {
        /* setup for haveloss functionalies*/
    }

    const handleHaveLossChange = (event) => {
        setIsHaveLossChecked(event.target.checked);
    };

    const dateOptions = [
        { value: 1, label: "MM/DD/YYYY" },
        { value: 2, label: "MM/YYYY" },
    ];

    const handleDateOptionsChange = (event) => {
        setHaveLossDateOption(event.value);
    };

    {
        /* end ofsetup for haveloss functionalies*/
    }

    const limitDropdownOptions = [
        { value: 300000, label: "$300,000" },
        { value: 500000, label: "$500,000" },
        { value: 1000000, label: "$1,000,000" },
    ];

    const workersCompFormData = {
        //workers comp object data common information
        lead_id: leadInstance?.data.id || null,
        is_owner_payroll_included: payrollDropdownValue,
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

    };
    console.log(workersCompFormData);



    function submitWorkersCompensationForm() {
        const generalInformationId = leadInstance?.data.id || null;
        const url = isUpdate
            ? `http://insuraprime_crm.test/api/workers-comp-data/${generalInformationId}`
            : `http://insuraprime_crm.test/api/workers-comp-data/store`;

        const method = isUpdate ? "put" : "post";

        axios[method](url, workersCompFormData)
            .then((response) => {
                SetIsEditing(false);
                SetIsUpdate(true);
                if(method == "post"){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: `Workers Compensation  has been saved` ,
                        showConfirmButton: false,
                    })
                }else{
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Workers Compensation has been successfully updated',
                        showConfirmButton: false,
                    })
                }
            })
            .catch((error) => {
                console.log("Error::", error);
                console.log("err:", error.response.data.message);
                Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    title: `Error:: kindly call your IT and Refer to them this error ${error.response.data.message}`,
                    showConfirmButton: false,
                })
            });
    }

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
            {/* <Row
                classValue="mb-3"
                rowContent={
                    <Column
                        key="addEmployeeDescription"
                        classValue="col-12"
                        colContent={
                            <>
                                <Label labelContent="Specific Description of Employees" />
                                <Form.Control
                                    as="textarea"
                                    rows={6}
                                    value={specificDescriptionOfEmployee}
                                    onChange={(e) =>
                                        setSpecificDescriptionOfEmployee(
                                            e.target.value
                                        )
                                    }
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />
                }
            /> */}
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
                            onChange={(e) => setPolicyLimit({value: e.value, label: `$${e.value}`})}
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
                                    onChange={(e) => setEachAccident({value: e.value, label: `$${e.value}`})}
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
                                    onChange={(e) => setEachEmployee({value: e.value, label: `$${e.value}`})}
                                    isDisabled={!isEditing}
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
                        classValue="col-6"
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
                                            disabled={!isEditing}
                                        />
                                    }
                                />
                            </>
                        }
                    />,
                    <Column
                        key="crossSellColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Cross Sell" />
                                <Select
                                    className="basic=single"
                                    classNamePrefix="select"
                                    id="generalLiabilitiesCrossSellDropdown"
                                    name="generalLiabilitiesCrossSellDropdown"
                                    isDisabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-3"
                rowContent={
                    <>
                        <Label labelContent="Remarks" />
                        <Form.Control
                            as={"textarea"}
                            rows={6}
                            value={remarks}
                            onChange={(e) => setRemarks(e.target.value)}
                            disabled={!isEditing}
                        />
                    </>
                }
            />
            {/* <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="workersCompAddButtonColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <div className="d-grid gap-2">
                                    <Button
                                        variant="success"
                                        size="lg"
                                        onClick={submitWorkersCompensationForm}
                                        disabled={!isEditing}
                                    >
                                        <SaveIcon />
                                    </Button>
                                </div>
                            </>
                        }
                    />,
                    <Column
                        key="workersCompEditButtonColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <div className="d-grid gap=2">
                                    <Button
                                        variant="primary"
                                        size="lg"
                                        disabled={isEditing}
                                        onClick={() => SetIsEditing(true)}
                                    >
                                        <SaveAsIcon />
                                    </Button>
                                </div>
                            </>
                        }
                    />,
                ]}
            /> */}

            <Row
                classValue="mb-3"
                rowContent={[

                    <Column
                        key="toolsEquipmentSubmmitButtonColumn"
                        classValue="col-10"
                        colContent={
                            <>

                            </>
                        }
                    />,
                    <Column
                        key="toolsEquipmentEdittButtonColumn"
                        classValue="col-2"
                        colContent={
                            <>
                            <Row
                              rowContent={
                                <>
                                    <Column
                                       key="submitButtonColumn"
                                       classValue="col-6"
                                       colContent={
                                        <div className="d-grid gap-2">
                                        <Button
                                        variant="success"
                                        size="lg"
                                        onClick={submitWorkersCompensationForm}
                                        disabled={!isEditing}
                                         >
                                         <SaveIcon />
                                         </Button>
                                         </div>

                                        }
                                    />
                                    <Column
                                       key="editButtonColumn"
                                       classValue="col-6"
                                       colContent={
                                        <div className="d-grid gap-2">
                                        <Button
                                        variant="primary"
                                        size="lg"
                                        disabled={isEditing}
                                        onClick={() => SetIsEditing(true)}
                                        >
                                         <SaveAsIcon />
                                        </Button>
                                            </div>
                                        }
                                    />
                                </>
                              }
                            />

                            </>
                        }
                    />,
                ]}
            />
        </>
    );
};

export default WorkersCompensationForm;
