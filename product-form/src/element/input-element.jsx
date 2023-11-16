import React from "react";
import { useFormContext, Controller } from "react-hook-form";
import Form from "react-bootstrap/Form";
import { Error } from "@mui/icons-material";
import { AnimatePresence, motion } from "framer-motion";
import { findInputError } from "../utils/findInputError";
import { isFormInvalid } from "../utils/isFormInvalid";

const Input = ({ label, type, inputValue, id, disabled, onChangeInput }) => {
    const { control, formState } = useFormContext();
    const { errors } = formState;

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
            <Controller
                name={label} // Assuming label corresponds to the input name
                control={control}
                defaultValue={inputValue}
                rules={{
                    required: "this form is required",
                }}
                render={({ field }) => (
                    <Form.Control
                        type={type}
                        className={errors[label] ? "is-invalid" : ""}
                        id={id}
                        value={field.value}
                        onChange={(e) => {
                            field.onChange(e);
                            onChangeInput(e.target.value);
                        }}
                        disabled={disabled}
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

export default Input;
