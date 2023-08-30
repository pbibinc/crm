import React, { useState } from "react";
import "react-datepicker/dist/react-datepicker.css";
import DatePicker from "react-datepicker";
import "../style/date-picker-input-style.css";

const DateDay = ({ disabled }) => {
    const [date, setDate] = useState(new Date());
    return (
        <DatePicker
            selected={date}
            onChange={(date) => setDate(date)}
            showMonthDropdown
            showYearDropdown
            className="custom-datepicker-input"
            disabled={disabled}
        />
    );
};

export default DateDay;
