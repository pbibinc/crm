import React, { useState } from "react";
import "react-datepicker/dist/react-datepicker.css";
import DatePicker from "react-datepicker";
import "../style/date-picker-input-style.css";
import Form from "react-bootstrap/Form";

const DateTime = () => {
    const [date, setDate] = useState(new Date());
    return (
        <>
            <style>{`.react-datepicker__input-container {display:none}`}</style>
            <DatePicker
                selected={date}
                onChange={(date) => setDate(date)}
                showTimeSelect
                showMonthDropdown
                showYearDropdown
                dateFormat="dd/MM/yyyy h:mm aa"
                className="custom-datepicker-input"
            />
        </>
    );
};

export default DateTime;
