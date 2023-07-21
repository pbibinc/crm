import React from "react";
import { useForm } from "react-hook-form";
const Input = ({ type, classValue, id, inputValue, validation }) => {
    const { register } = useForm();
    return (
        <input
            type={type}
            className={classValue}
            id={id}
            defaultValue={inputValue}
            {...register(id, { validation })}
        />
    );
};
export default Input;
