import React from "react";
import { useForm } from "react-hook-form";
const Input = ({
    type,
    classValue,
    id,
    inputValue,
    validation,
    onBlur,
    onChange,
}) => {
    const { register } = useForm();
    return (
        <input
            type={type}
            className={classValue}
            id={id}
            defaultValue={inputValue}
            onBlur={onBlur}
            onChange={onChange}
            {...register(id, { validation })}
        />
    );
};
export default Input;
