import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const userData = () => {
    const [user, setUser] = useState(null);

    useEffect(() => {
        const fetchAuthToken = async () => {
            try {
                const response = await axiosClient.get(`/api/get-user`);
                setUser(response.data.user);
            } catch (error) {
                console.error("Error fetching auth token", error);
            }
        };

        if (!user) {
            fetchAuthToken(); // Fetch the token only if it's not already set
        }
    }, []);

    return { user };
};

export default userData;
