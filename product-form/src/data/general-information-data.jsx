import { useEffect, useState } from "react";
import LeadDetails from "./lead-details";

const GeneralInformationData = () => {
    const [generalInformation, setGeneralInformation] = useState(null);
    const leadDetailsInstance = LeadDetails();
    useEffect(() => {
        const fetchGenerealInformation = async () => {
            try {
                const respons = await fetch(
                    `http://crm.pbibinc.com//api/general_information`
                );
                const data = await respons.json();
                setGeneralInformation(data);
            } catch (error) {
                console.error("Error fetching general information", error);
            }
        };
        fetchGenerealInformation();
    }, []);

    const leadId = leadDetailsInstance?.data?.id;
    const generalInformationMapped = generalInformation?.data?.filter(
        (item) => item.leads_id === leadId
    );
    return generalInformationMapped;
};

export default GeneralInformationData;
