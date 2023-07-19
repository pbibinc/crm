import State from "pusher-js/types/src/core/http/state";
import { createContext, useContext, useState } from "react";

const Context = createContext({
    leadState: null,
    token: null,
});

export const ContextProvider = ({ children }) => {
    const [leadState, setLeadState] = useState({});
    const [token, _setToken] = useState(localStorage.getItem("token"));

    const setToken = (token) => {
        _setToken(token);
        if (token) {
            localStorage.setItem("token", token);
        } else {
            localStorage.removeItem("token");
        }
    };
    return (
        <Context.Provider
            value={{
                leadState,
                token,
                setLeadState,
                setToken,
            }}
        >
            {children}
        </Context.Provider>
    );
};

export const useStateContext = () => useContext(Context);
