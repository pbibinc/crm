import { useEffect, useState } from "react";
import GeneralInformationData from "./general-information-data";
import axios from "axios";

const WorkersCompData = () => {
    const [workersComp, setWorkersComp] = useState(null);
    const [fetched, setFetched] = useState(false);
    const generalInformationInstance = GeneralInformationData();

    useEffect(() => {
        if (
            generalInformationInstance &&
            generalInformationInstance.length > 0 &&
            !fetched
        ) {
            axios
                .get(
                    `http://insuraprime_crm.test/api/workers-comp-data/get/${generalInformationInstance[0].id}`
                )
                .then((response) => {
                    setWorkersComp(response.data);
                    setFetched(true);
                })
                .catch((error) => {
                    // console.log(error);
                });
        }
    }, [generalInformationInstance, fetched]); // Only re-run the effect if generalInformationInstance changes

    if (workersComp == null) {
        return null;
    } else {
        return workersComp;
    }
};

export default WorkersCompData;