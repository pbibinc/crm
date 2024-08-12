import { createContext, useContext } from "react";

export const WorkersCompensationContext = createContext();

export const useWorkersCompensation = () =>
    useContext(WorkersCompensationContext);
