import React from "react";
import { useForm, useFormContext } from "react-hook-form";
import { NumericFormat } from "react-number-format";
import { findInputError } from "../utils/findInputError";
import { isFormInvalid } from "../utils/isFormInvalid";
import { AnimatePresence, motion } from "framer-motion";
import { Error } from "@mui/icons-material";
const NumericFormatInput = ({ onChange, label, value, disabled }) => {
    const {
        register,
        formState: { errors },
    } = useFormContext();

    const inputError = findInputError(errors, label);
    const isInvalid = isFormInvalid(inputError);
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
            <NumericFormat
                className={
                    errors[label] ? "is-invalid form-control" : "form-control"
                }
                thousandSeparator={true}
                prefix={"$"}
                decimalScale={2}
                fixedDecimalScale={true}
                allowNegative={false}
                placeholder="$0.00"
                value={value}
                disabled={disabled}
                onChange={onChange}
                {...register(label, {
                    required: {
                        value: true,
                        message: "required",
                    },
                })}
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
