import { createBrowserRouter } from "react-router-dom";
import AppointedLeadQuestionare from "./views/appoinnted-lead-questionare.jsx";
import GeneralLiabilitiesForm from "./product-form/general-liabilites-form.jsx";
import ContextDataProvider from "./contexts/context-data-provider.jsx";

const router = createBrowserRouter([
    {
        path: "/appoinnted-lead-questionare",
        element: <AppointedLeadQuestionare />,
    },
    {
        path: "/general-liabilities-form",
        element: (
            <ContextDataProvider>
                <GeneralLiabilitiesForm />
            </ContextDataProvider>
        ),
    },
    {
        path: "*",
        element: <div>404</div>,
    },
]);

export default router;
