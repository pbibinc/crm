import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const useAuthToken = () => {
    const [authToken, setAuthToken] = useState(null);

    useEffect(() => {
        const fetchAuthToken = async () => {
            try {
                const response = await axiosClient.post(
                    `/api/generate-auth-token`
                );
                setAuthToken(response.data.token);
            } catch (error) {
                console.error("Error fetching auth token", error);
            }
        };

        if (!authToken) {
            fetchAuthToken(); // Fetch the token only if it's not already set
        }
    }, []);

    return { authToken };
};

export default useAuthToken;
