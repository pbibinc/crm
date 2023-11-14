import InputMask from "react-input-mask";
import React from "react";
import { findInputError } from "../utils/findInputError";
import { isFormInvalid } from "../utils/isFormInvalid";
import { AnimatePresence, motion } from "framer-motion";
import { Error } from "@mui/icons-material";
import { useForm, useFormContext } from "react-hook-form";
import Select from "react-select";

const SelectDropdownElement = ({
    value,
    isDisabled,
    label,
    onChange,
    id,
    name,
    options,
}) => {
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
            <Select
                id={id}
                name={name}
                options={options}
                value={value}
                isDisabled={isDisabled}
                onChange={onChange}
                className="basic-single"
                classNamePrefix="select"
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

export default SelectDropdownElement;
