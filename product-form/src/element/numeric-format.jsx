import React from "react";
import { Controller, useForm, useFormContext } from "react-hook-form";
import { NumericFormat } from "react-number-format";
import { findInputError } from "../utils/findInputError";
import { isFormInvalid } from "../utils/isFormInvalid";
import { AnimatePresence, motion } from "framer-motion";
import { Error } from "@mui/icons-material";

const NumericFormatInput = ({
    label,
    disabled,
    id,
    name,
    inputValue,
    onChangeInput,
}) => {
    const { control, formState } = useFormContext();
    const { errors } = formState;
    const inputError = findInputError(errors, label);
    const isInvalid = isFormInvalid(inputError);

    const handleChanged = (values) => {
        const inputValue = values.floatValue;
        setValue(label, inputValue);

        if (!inputValue || inputValue <= 0) {
            setValue(label, null);
        }
    };
    return (
        <div className="flex flex-col w-full gap-2">
            <AnimatePresence mode="wait" initial={false}>
                {isInvalid && (
                    <InputError
                        message={inputError[label].message || ""}
                        key={inputError[label].message || ""}
                    />
                )}
            </AnimatePresence>
            <Controller
                name={label}
                control={control}
                defaultValue={inputValue}
                rules={{ required: "this form is required" }}
                render={({ field }) => (
                    <NumericFormat
                        className={
                            errors[label]
                                ? "is-invalid form-control"
                                : "form-control"
                        }
                        value={field.value}
                        id={id}
                        thousandSeparator={true}
                        prefix={"$"}
                        decimalScale={2}
                        fixedDecimalScale={true}
                        allowNegative={false}
                        placeholder="$0.00"
                        disabled={disabled}
                        onValueChange={(values) => {
                            field.onChange(values.floatValue);
                            onChangeInput(values.floatValue);
                        }}
                        name={name}
                    />
                )}
            />
        </div>
    );
};
const InputError = ({ message }) => {
    const errorStyle = {
        color: "red",
    };
    return (
        <motion.p
            style={errorStyle}
            className="flex items-center gap-1 px-2 font-semibold bg-red-100 rounded-md"
            {...framer_error}
        >
            <Error /> {message}
        </motion.p>
    );
};

const framer_error = {
    initial: { opacity: 0, y: 10 },
    animate: { opacity: 1, y: 0 },
    exit: { opacity: 0, y: 10 },
    transition: { duration: 0.2 },
};
export default NumericFormatInput;
