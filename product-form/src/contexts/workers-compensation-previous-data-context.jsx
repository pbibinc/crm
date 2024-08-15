import { createContext, useContext } from "react";

export const WorkersCompensationPreviousDataContext = createContext();

export const useWorkersCompensationPrevious = () =>
    useContext(WorkersCompensationPreviousDataContext);
